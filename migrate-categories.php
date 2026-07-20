<?php
/**
 * migrate-categories.php
 *
 * Migrates the category tree from a LIVE Magento DB into the current
 * (FRESH) Magento instance, using Magento's own Category API so that
 * URL rewrites, validation, and indexing hooks all run normally.
 *
 * WHERE TO RUN THIS:
 *   Place this file in the ROOT of your FRESH Magento install
 *   (same folder as bin/magento) and run it with:
 *
 *       php migrate-categories.php
 *
 * WHAT IT DOES:
 *   1. Opens a direct read-only PDO connection to the LIVE database.
 *   2. Reads the live category tree (catalog_category_entity + EAV values).
 *   3. Walks it top-down (by level) and creates each category on the
 *      FRESH instance via Magento\Catalog\Api\CategoryRepositoryInterface,
 *      mapping old category_id -> new category_id so children attach to
 *      the correct new parent.
 *
 * WHAT IT DOES NOT DO:
 *   - Category images (media) are not copied — see the TODO in
 *     mapCategoryData() if you want to add that.
 *   - Anchor/product-in-category assignments are not touched (that's
 *     product data, not category data).
 *   - Store-view-specific overrides (different name/url_key per store
 *     view) are not migrated — only default (store_id = 0) values.
 *
 * BEFORE RUNNING:
 *   - Fill in the LIVE_DB_* constants below.
 *   - Take a DB backup of the fresh instance first.
 *   - Make sure the fresh instance's root category structure is what
 *     you expect (script maps live's root children under fresh's
 *     existing default root category).
 */

use Magento\Framework\App\Bootstrap;
use Magento\Catalog\Api\Data\CategoryInterfaceFactory;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Model\Category;
use Magento\Store\Model\StoreManagerInterface;

require __DIR__ . '/app/bootstrap.php';

// ----------------------------------------------------------------------
// 1. CONFIG — fill these in
// ----------------------------------------------------------------------
const LIVE_DB_HOST = 'localhost';   // live DB host
const LIVE_DB_NAME = 'theutilitykilt';
const LIVE_DB_USER = 'root';
const LIVE_DB_PASS = 'password';

// Which attributes to pull across (attribute_code => target Category setter data key)
const ATTRIBUTES_TO_COPY = [
    'name',
    'is_active',
    'description',
    'url_key',
    'meta_title',
    'meta_keywords',
    'meta_description',
    'include_in_menu',
    'display_mode',
    'landing_page',
    'is_anchor',
];

// The category_id in the FRESH instance that live's root children should
// be attached under. 2 is Magento's standard default root category.
const FRESH_TARGET_ROOT_ID = 2;

// ----------------------------------------------------------------------
// 2. Bootstrap Magento (FRESH instance)
// ----------------------------------------------------------------------
$bootstrap = Bootstrap::create(BP, $_SERVER);
$objectManager = $bootstrap->getObjectManager();
$state = $objectManager->get(\Magento\Framework\App\State::class);
$state->setAreaCode('adminhtml');

/** @var CategoryRepositoryInterface $categoryRepository */
$categoryRepository = $objectManager->get(CategoryRepositoryInterface::class);
/** @var CategoryInterfaceFactory $categoryFactory */
$categoryFactory = $objectManager->get(CategoryInterfaceFactory::class);
/** @var StoreManagerInterface $storeManager */
$storeManager = $objectManager->get(StoreManagerInterface::class);
$storeManager->setCurrentStore(0); // admin/default scope

// ----------------------------------------------------------------------
// 3. Connect directly to LIVE DB (read-only)
// ----------------------------------------------------------------------
$liveDb = new PDO(
    'mysql:host=' . LIVE_DB_HOST . ';dbname=' . LIVE_DB_NAME . ';charset=utf8mb4',
    LIVE_DB_USER,
    LIVE_DB_PASS,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

// ----------------------------------------------------------------------
// 4. Fetch the live category tree structure
// ----------------------------------------------------------------------
$stmt = $liveDb->query("
    SELECT entity_id, parent_id, level, position, path
    FROM catalog_category_entity
    ORDER BY level ASC, position ASC
");
$liveCategories = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "Found " . count($liveCategories) . " categories on live.\n";

// ----------------------------------------------------------------------
// 5. Fetch EAV attribute values for the attributes we care about
//    (varchar, int, text — covers everything in ATTRIBUTES_TO_COPY)
// ----------------------------------------------------------------------
function fetchAttributeMap(PDO $db, array $attributeCodes): array
{
    $placeholders = implode(',', array_fill(0, count($attributeCodes), '?'));

    $attrRows = $db->prepare("
        SELECT attribute_id, attribute_code, backend_type
        FROM eav_attribute
        WHERE entity_type_id = (
            SELECT entity_type_id FROM eav_entity_type
            WHERE entity_type_code = 'catalog_category'
        )
        AND attribute_code IN ($placeholders)
    ");
    $attrRows->execute($attributeCodes);
    $attrMeta = $attrRows->fetchAll(PDO::FETCH_ASSOC);

    $values = []; // [entity_id][attribute_code] = value

    foreach ($attrMeta as $attr) {
        $backendType = $attr['backend_type']; // varchar, int, text, decimal, datetime
        if ($backendType === 'static') {
            continue; // handled separately (entity_id, parent_id, etc.)
        }
        $table = "catalog_category_entity_{$backendType}";
        $valStmt = $db->prepare("
            SELECT entity_id, value
            FROM {$table}
            WHERE attribute_id = ? AND store_id = 0
        ");
        $valStmt->execute([$attr['attribute_id']]);
        foreach ($valStmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $values[$row['entity_id']][$attr['attribute_code']] = $row['value'];
        }
    }

    return $values;
}

$attributeValues = fetchAttributeMap($liveDb, ATTRIBUTES_TO_COPY);

// ----------------------------------------------------------------------
// 6. Walk the tree top-down and create categories on FRESH
// ----------------------------------------------------------------------
$idMap = []; // live entity_id => new fresh category_id
$skipped = [];
$created = 0;

foreach ($liveCategories as $row) {
    $liveId = (int) $row['entity_id'];
    $level = (int) $row['level'];
    $liveParentId = (int) $row['parent_id'];

    // Skip level 0 (the absolute root) and level 1 (live's default root,
    // e.g. entity_id 2) — fresh already has its own equivalents.
    if ($level <= 1) {
        // Map live's root (level 1) to fresh's existing root so children
        // of it attach correctly.
        $idMap[$liveId] = FRESH_TARGET_ROOT_ID;
        continue;
    }

    $newParentId = $idMap[$liveParentId] ?? null;
    if ($newParentId === null) {
        // Parent wasn't created (shouldn't happen since we order by level)
        $skipped[] = $liveId;
        continue;
    }

    $data = $attributeValues[$liveId] ?? [];

    if (empty($data['name'])) {
        // Category has no name value — skip rather than create junk
        $skipped[] = $liveId;
        continue;
    }

    try {
        /** @var Category $category */
        $category = $categoryFactory->create();
        $category->setName($data['name']);
        $category->setParentId($newParentId);
        $category->setIsActive(isset($data['is_active']) ? (bool) $data['is_active'] : true);
        $category->setDisplayMode($data['display_mode'] ?? 'PRODUCTS');
        $category->setIsAnchor(isset($data['is_anchor']) ? (bool) $data['is_anchor'] : true);

        if (!empty($data['description'])) {
            $category->setCustomAttribute('description', $data['description']);
        }
        if (!empty($data['meta_title'])) {
            $category->setCustomAttribute('meta_title', $data['meta_title']);
        }
        if (!empty($data['meta_keywords'])) {
            $category->setCustomAttribute('meta_keywords', $data['meta_keywords']);
        }
        if (!empty($data['meta_description'])) {
            $category->setCustomAttribute('meta_description', $data['meta_description']);
        }
        if (!empty($data['include_in_menu'])) {
            $category->setIncludeInMenu((bool) $data['include_in_menu']);
        }
        if (!empty($data['url_key'])) {
            // Let Magento auto-generate if it collides; setUrlKey is a hint,
            // not a hard guarantee, if there's a conflict.
            $category->setUrlKey($data['url_key']);
        }

        $categoryRepository->save($category);
        $idMap[$liveId] = (int) $category->getId();
        $created++;

        echo "Created: {$data['name']} (live #{$liveId} -> fresh #{$category->getId()})\n";
    } catch (\Throwable $e) {
        echo "FAILED live #{$liveId} ({$data['name']}): " . $e->getMessage() . "\n";
        $skipped[] = $liveId;
    }
}

// ----------------------------------------------------------------------
// 7. Summary
// ----------------------------------------------------------------------
echo "\n----------------------------------------\n";
echo "Done. Created: {$created}. Skipped: " . count($skipped) . "\n";
if ($skipped) {
    echo "Skipped live IDs: " . implode(', ', $skipped) . "\n";
}
echo "\nNow run:\n";
echo "  bin/magento indexer:reindex\n";
echo "  bin/magento cache:flush\n";
