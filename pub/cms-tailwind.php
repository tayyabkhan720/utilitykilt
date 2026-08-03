<?php
/**
 * Hyvä Themes - https://hyva.io
 * Copyright © Hyvä Themes 2020-present. All rights reserved.
 * This product is licensed per Magento install
 * See https://hyva.io/license
 *
 * Standalone CMS Tailwind Compiler compilation endpoint.
 * Bypasses Magento bootstrap for maximum speed (~1ms auth overhead).
 * Validates requests using HMAC tokens tied to the admin session cookie.
 *
 * Requires web server configuration to route requests to this file.
 * See README.md for nginx configuration examples.
 *
 * The HMAC algorithm and HTTP/1.1 daemon proxy used here are loaded from the
 * shared files in ../src/Shared/, which are also used by the Magento module
 * classes (HmacToken.php and DaemonClient.php). The algorithm therefore
 * cannot drift between the two callers.
 */

// PHP-FPM does not resolve symlinks for __FILE__/__DIR__ (only the CLI does),
// so when this file is symlinked from vendor/ into pub/ we must resolve the
// real path explicitly. Otherwise __DIR__ points at the symlink directory
// (e.g. /pub/) and the relative require below fails.
$packagePubDir = dirname(realpath(__FILE__) ?: __FILE__);

// The shared helpers live in the package's src/Shared. This endpoint may be
// deployed into pub/ either as a SYMLINK (realpath above points back into the
// package, so ../src/Shared resolves) or as a real COPY — the Magento Composer
// Installer supports both deploy strategies. In the copy case ../src/Shared
// would point at <magento-root>/src (which does not exist), so fall back to the
// Composer-installed package path under the Magento root. These requires run
// before the error boundary is loaded, so a genuinely missing library is
// reported as clean JSON rather than leaking a PHP fatal as HTML — which would
// break the bridge's response.json().
$sharedDir = $packagePubDir . '/../src/Shared';
if (!is_file($sharedDir . '/Hmac.php')) {
    $documentRoot = $_SERVER['DOCUMENT_ROOT'] ?? '';
    $magentoRoot = ($documentRoot !== '' && is_dir($documentRoot . '/../app/etc'))
        ? dirname($documentRoot)
        : dirname(__DIR__);
    $sharedDir = $magentoRoot . '/vendor/hyva-themes/magento2-cms-tailwind-compiler/src/Shared';
}
if (!is_file($sharedDir . '/Hmac.php')) {
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode(['error' => 'CMS Tailwind compiler shared library not found']);
    exit;
}
require_once $sharedDir . '/Hmac.php';
require_once $sharedDir . '/DaemonProxy.php';
require_once $sharedDir . '/JsonErrorBoundary.php';

use Hyva\CmsTailwindCompiler\Shared\DaemonProxy;
use Hyva\CmsTailwindCompiler\Shared\Hmac;
use Hyva\CmsTailwindCompiler\Shared\JsonErrorBoundary;

// Resolve Magento root.
// Cannot use __DIR__ because this file may be a symlink from vendor/ to pub/.
// Use DOCUMENT_ROOT (the web server's pub/ directory) to find the Magento root.
if (!defined('BP')) {
    $documentRoot = $_SERVER['DOCUMENT_ROOT'] ?? '';
    if ($documentRoot !== '' && is_dir($documentRoot . '/../app/etc')) {
        define('BP', dirname($documentRoot));
    } elseif (is_dir(__DIR__ . '/../app/etc')) {
        // Fallback: file is a real copy in pub/ (not a symlink)
        define('BP', dirname(__DIR__));
    } else {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode(['error' => 'Cannot determine Magento root directory']);
        exit;
    }
}

// ─── Error Boundary ──────────────────────────────────────────────────────────

// Wrap the entire request body in JsonErrorBoundary::run() so any uncaught
// PHP notice, warning, exception, or fatal becomes a uniform JSON envelope
// (`{"error": "PHP error, check var/log/cms-tailwind-compiler.log",
// "requestId": "..."}` + HTTP 500) and gets logged in full to the dedicated
// log file. The shape matches the Magento controllers' JsonApiAction base
// class byte-for-byte so the bridge JS can treat both endpoints identically.
JsonErrorBoundary::run('handleCompileRequest', JsonErrorBoundary::logPath(BP));
exit;

function handleCompileRequest(): void
{
// ─── Configuration ───────────────────────────────────────────────────────────

$env = require BP . '/app/etc/env.php';

$cryptKey = $env['crypt']['key'] ?? '';
if ($cryptKey === '') {
    sendJson(500, ['error' => 'Deployment configuration missing encryption key']);
}

$config = $env['hyva_cms_tailwind'] ?? [];

// Read allowed themes (written by the Magento module)
$allowedThemesPath = BP . '/var/hyva_cms_tailwind_allowed_themes.json';
// Cast file_get_contents to string: it returns false if the file disappears
// between file_exists() and the read, and PHP 8.1+ deprecates passing non-string
// to json_decode.
$allowedThemes = file_exists($allowedThemesPath)
    ? (json_decode((string) file_get_contents($allowedThemesPath), true) ?: [])
    : [];

// Read daemon auth token from state file
$daemonStatePath = BP . '/var/hyva_cms_tailwind_daemon.json';
$daemonAuthToken = readDaemonAuthToken($daemonStatePath);

$transport   = $config['transport'] ?? 'tcp';
$tcpHost     = $config['tcp_host'] ?? '127.0.0.1';
$tcpPort     = (int) ($config['tcp_port'] ?? 3200);
$socketPath  = $config['socket_path'] ?? '/tmp/hyva-cms-tailwind.sock';
$connectTimeoutMs = (int) ($config['connect_timeout_ms'] ?? 100);
$readTimeoutMs    = (int) ($config['read_timeout_ms'] ?? 2500);

// ─── Request Validation ──────────────────────────────────────────────────────

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendJson(405, ['error' => 'Method not allowed']);
}

// ─── HMAC Token Validation ───────────────────────────────────────────────────

// Auth model: HMAC token over `crypt/key` + a 1-hour rolling time window. The
// admin session cookie is intentionally NOT consulted — its `path=/admin/`
// scope means it is never sent to this root-path endpoint, and bootstrapping
// Magento just to look it up would defeat the whole purpose of the standalone
// endpoint (~1ms vs ~20ms). Anyone who could read the rendered token from a
// Hyvä CMS admin page can replay it for up to ~2 hours (current + previous
// window). Acceptable because the endpoint only compiles Tailwind from
// on-disk theme directories — it does not read or mutate Magento state.

$receivedToken = $_SERVER['HTTP_X_HYVA_CMS_TOKEN'] ?? '';
if ($receivedToken === '') {
    sendJson(401, ['error' => 'Missing authentication token']);
}

if (!Hmac::validate($receivedToken, $cryptKey, time())) {
    sendJson(401, ['error' => 'Invalid authentication token']);
}

// ─── Body Parsing ───────────────────────────────────────────────────────────

// 1 MiB cap (1048576 bytes). The maxlen below is 1 byte over so we can
// distinguish "exactly at the cap" from "over the cap". Keep these values
// in lockstep with:
//   - MAX_BODY in node/lib/daemon.mjs
//   - the size check in src/Controller/Adminhtml/Compile/Index.php
$body = file_get_contents('php://input', false, null, 0, 1048577);
if ($body === false || $body === '') {
    sendJson(400, ['error' => 'Empty request body']);
}
if (strlen($body) > 1048576) {
    sendJson(413, ['error' => 'Request body too large']);
}

$decoded = json_decode($body, true);
if (!is_array($decoded)) {
    sendJson(400, ['error' => 'Invalid JSON']);
}

if (!isset($decoded['html'])) {
    sendJson(400, ['error' => 'Missing required field: html']);
}

if (!isset($decoded['themes']) || !is_array($decoded['themes'])) {
    sendJson(400, ['error' => 'Missing required field: themes']);
}

// Reject `themes` sent as a JSON list (e.g. ["Hyva/default"]) — the
// resolver reads theme codes from array *keys*, so a numeric-indexed
// list silently produces zero matches and a misleading "no valid themes"
// error. Catch it here with a clearer message instead.
if (!empty($decoded['themes']) && array_is_list($decoded['themes'])) {
    sendJson(400, [
        'error' => 'themes must be an object keyed by theme code (e.g. {"Hyva/default": "/web/tailwind"}), not a list',
    ]);
}

// scopeSelector and layer are interpolated verbatim into the emitted CSS
// by node/lib/scoper.mjs — reject anything outside a conservative char-class
// so a caller cannot inject `</style>` (HTML breakout when the CSS is later
// rendered) or `}` (escape from the @layer wrapper). The Magento controller
// applies the same check; this is the standalone-endpoint mirror.
if (isset($decoded['scopeSelector']) && $decoded['scopeSelector'] !== ''
    && !isValidScopeSelector($decoded['scopeSelector'])
) {
    sendJson(400, ['error' => 'Invalid scopeSelector']);
}
if (array_key_exists('layer', $decoded)
    && $decoded['layer'] !== null
    && $decoded['layer'] !== false
    && $decoded['layer'] !== ''
    && !isValidLayerName($decoded['layer'])
) {
    sendJson(400, ['error' => 'Invalid layer']);
}

// Validate theme paths against the allowed themes map
if (empty($allowedThemes)) {
    sendJson(503, ['error' => 'Theme allowlist not available. Load the admin CMS editor first.']);
}

$validatedThemes = [];
foreach (array_keys($decoded['themes']) as $themeCode) {
    if (isset($allowedThemes[$themeCode])) {
        $validatedThemes[$themeCode] = $allowedThemes[$themeCode];
    }
}

// Resolve previewTheme (a theme code string) to { code: path } for the daemon
$previewThemeCode = $decoded['previewTheme'] ?? null;
$resolvedPreviewTheme = null;
if ($previewThemeCode !== null) {
    if (!is_string($previewThemeCode) || $previewThemeCode === '') {
        sendJson(400, ['error' => 'previewTheme must be a non-empty theme code string']);
    }
    if (isset($allowedThemes[$previewThemeCode])) {
        $resolvedPreviewTheme = [$previewThemeCode => $allowedThemes[$previewThemeCode]];
    } else {
        sendJson(400, ['error' => 'Invalid preview theme: ' . $previewThemeCode]);
    }
}

if (empty($validatedThemes) && $resolvedPreviewTheme === null) {
    sendJson(400, ['error' => 'No valid Hyvä themes in request']);
}

$decoded['themes'] = $validatedThemes;
if ($resolvedPreviewTheme !== null) {
    $decoded['previewTheme'] = $resolvedPreviewTheme;
} else {
    unset($decoded['previewTheme']);
}
$body = json_encode($decoded);
if ($body === false) {
    sendJson(400, ['error' => 'Failed to encode request']);
}

// ─── Proxy to Daemon ─────────────────────────────────────────────────────────

$address = $transport === 'unix_socket'
    ? 'unix://' . $socketPath
    : 'tcp://' . $tcpHost . ':' . $tcpPort;

$result = DaemonProxy::send(
    $address,
    $body,
    $daemonAuthToken !== '' ? $daemonAuthToken : null,
    $connectTimeoutMs / 1000,
    $readTimeoutMs / 1000
);

// Cold path: daemon is unreachable. The standalone endpoint is intentionally
// bootstrap-free for the hot path (~1ms vs ~20ms with Magento init), but it
// also owns the on-demand trigger so the responsibility doesn't leak into
// other modules. We only pay the bootstrap cost here when the daemon isn't
// already up, which is the same request in which we'd fork a Node process
// anyway — bootstrap is dwarfed by the daemon spawn.
if (!$result['ok'] && ($result['error'] ?? '') === 'connect_failed') {
    if (tryStartDaemonOnDemand(BP)) {
        $daemonAuthToken = readDaemonAuthToken($daemonStatePath);
        $result = DaemonProxy::send(
            $address,
            $body,
            $daemonAuthToken !== '' ? $daemonAuthToken : null,
            $connectTimeoutMs / 1000,
            $readTimeoutMs / 1000
        );
    }
}

if (!$result['ok']) {
    $error = $result['error'] ?? 'unknown';
    if ($error === 'connect_failed') {
        sendJson(502, ['error' => 'Compilation service unavailable']);
    }
    if ($error === 'write_failed') {
        sendJson(502, ['error' => 'Failed to write to compilation service']);
    }
    if ($error === 'read_timeout') {
        sendJson(504, ['error' => 'Compilation service timed out']);
    }
    if ($error === 'truncated') {
        sendJson(502, [
            'error' => 'Truncated response from compilation service',
            'expected' => $result['expectedLength'] ?? null,
            'received' => $result['receivedLength'] ?? null,
        ]);
    }
    sendJson(502, ['error' => 'Malformed response from compilation service']);
}

// Forward the daemon's response as-is
header('Content-Type: application/json');
http_response_code($result['statusCode']);
echo $result['body'];
exit;
}

// ─── Helpers ─────────────────────────────────────────────────────────────────

function sendJson(int $status, array $data): never
{
    header('Content-Type: application/json');
    http_response_code($status);
    echo json_encode($data);
    exit;
}

// Mirror of node/lib/validate-request.mjs SCOPE_SELECTOR_RE.
function isValidScopeSelector(mixed $value): bool
{
    return is_string($value)
        && $value !== ''
        && strlen($value) <= 128
        && preg_match('/^[a-zA-Z0-9_.#:\-\[\]="\',\s]+$/', $value) === 1;
}

// Mirror of node/lib/validate-request.mjs LAYER_NAME_RE.
function isValidLayerName(mixed $value): bool
{
    return is_string($value)
        && $value !== ''
        && strlen($value) <= 64
        && preg_match('/^[a-zA-Z0-9_-]+$/', $value) === 1;
}

// Read the daemon's bearer token from the JSON state file written by
// DaemonManager. Returns '' when the file is missing or unreadable — the
// daemon also rejects requests without a token, so a missing file fails
// safely as 401 rather than allowing unauthenticated access.
function readDaemonAuthToken(string $statePath): string
{
    if (!file_exists($statePath)) {
        return '';
    }
    $stateData = json_decode((string) file_get_contents($statePath), true);
    return is_array($stateData) ? (string) ($stateData['auth_token'] ?? '') : '';
}

// Bootstrap Magento just enough to check on-demand daemon-management config
// and, when enabled, fork the daemon via DaemonManager. Returns true when
// the daemon is healthy after the call. Only invoked when the hot-path proxy
// got connect_failed, so the ~20ms bootstrap cost is acceptable — and is
// paid once per daemon downtime, not once per request.
function tryStartDaemonOnDemand(string $magentoRoot): bool
{
    // Wrap the entire bootstrap in a try/catch: any failure (autoload error,
    // misconfigured env.php, unreachable DB during scope-config read) must
    // not turn a 502 daemon-unavailable into a 500 — fall through to the
    // existing error reporting.
    try {
        require_once $magentoRoot . '/app/bootstrap.php';
        $bootstrap = \Magento\Framework\App\Bootstrap::create($magentoRoot, $_SERVER);
        $objectManager = $bootstrap->getObjectManager();

        $config = $objectManager->get(\Hyva\CmsTailwindCompiler\Model\Config::class);
        if (!$config->isOnDemandDaemonManagerEnabled()) {
            return false;
        }

        $daemonManager = $objectManager->get(\Hyva\CmsTailwindCompiler\Model\DaemonManager::class);
        if ($daemonManager->isRunning()) {
            return true;
        }
        return $daemonManager->start();
    } catch (\Throwable $e) {
        error_log('Hyva_CmsTailwindCompiler: on-demand daemon start failed during bootstrap: ' . $e->getMessage());
        return false;
    }
}
