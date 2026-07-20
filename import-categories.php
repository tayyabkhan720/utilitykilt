<?php
/**
 * import-categories.php
 *
 * Imports categories from categories_export_fixed.csv into the current
 * (FRESH) Magento instance, using Magento's own Category API so that
 * URL rewrites, validation, and indexing hooks all run normally.
 *
 * WHERE TO RUN THIS:
 *   1. Place categories_export_fixed.csv in the SAME folder as this script.
 *   2. Place this script in the ROOT of your FRESH Magento install
 *      (same folder as bin/magento).
 *   3. Run it with:
 *
 *          php import-categories.php
 *
 * CSV COLUMNS EXPECTED (in this exact order):
 *   entity_id, name, url_key, is_active, parent_id, path, level, description
 *
 * WHAT IT DOES:
 *   1. Reads every row from the CSV.
 *   2. Sorts rows by level (ascending) so parents are always created
 *      before their children, regardless of the CSV's row order.
 *   3. Skips level 0 (absolute root) and level 1 (live's default root) —
 *      maps them to FRESH_TARGET_ROOT_ID instead, since fresh already
 *      has its own root category.
 *   4. Creates each remaining category via CategoryRepositoryInterface,
 *      keeping a map of old (live) entity_id -> new (fresh) category_id
 *      so children attach to the correct newly created parent.
 *
 * WHAT IT DOES NOT DO:
 *   - Category images are not copied.
 *   - Store-view-specific overrides are not set — only default (admin)
 *     scope values (name, description, url_key, is_active).
 *
 * BEFORE RUNNING:
 *   - Take a DB backup of the fresh instance first.
 *   - Confirm FRESH_TARGET_ROOT_ID matches your fresh instance's actual
 *     root category (usually 2 — check Catalog > Categories in admin).
 *   - Dry-run first with DRY_RUN = true to sanity-check the plan before
 *     writing anything.
 */

use Magento\Framework\App\Bootstrap;
use Magento\Catalog\Api\Data\CategoryInterfaceFactory;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Model\Category;
use Magento\Store\Model\StoreManagerInterface;

require __DIR__ . '/app/bootstrap.php';

// ----------------------------------------------------------------------
// 1. CONFIG
// ----------------------------------------------------------------------
const CSV_FILE = __DIR__ . '/categories_export_fixed.csv';

// The category_id in the FRESH instance that live's root children should
// be attached under. 2 is Magento's standard default root category.
const FRESH_TARGET_ROOT_ID = 2;

// The store view ID to use for the INITIAL save of each category.
// Magento has a known core bug where saving categories in "All Store
// Views" scope (store_id = 0) fails validation on any instance with
// more than one store view — the "Category Name 2" error is that bug
// (see magento/magento2#22309). Using a real store view ID for the
// first save avoids it. Check yours with `bin/magento store:list`.
const IMPORT_STORE_ID = 1;

// After the initial save, the script re-saves each category's name and
// description under every OTHER real store view too, so every storefront
// on a multi-site/multi-store instance actually shows the category
// (without this, only IMPORT_STORE_ID's storefront would show it —
// other store views would see a blank name). Set to false if you only
// have one store view, or only want it visible on IMPORT_STORE_ID.
const PROPAGATE_TO_ALL_STORES = true;

// Set to true to print what WOULD be created without actually saving
// anything — recommended for a first pass.
const DRY_RUN = false;

// ----------------------------------------------------------------------
// 2. Bootstrap Magento (FRESH instance)
// ----------------------------------------------------------------------
$bootstrap = Bootstrap::create(BP, $_SERVER);
$objectManager = $bootstrap->getObjectManager();
$state = $objectManager->get(\Magento\Framework\App\State::class);
try {
    $state->setAreaCode('adminhtml');
} catch (\Magento\Framework\Exception\LocalizedException $e) {
    // area code already set — safe to ignore
}

/** @var CategoryRepositoryInterface $categoryRepository */
$categoryRepository = $objectManager->get(CategoryRepositoryInterface::class);
/** @var CategoryInterfaceFactory $categoryFactory */
$categoryFactory = $objectManager->get(CategoryInterfaceFactory::class);
/** @var StoreManagerInterface $storeManager */
$storeManager = $objectManager->get(StoreManagerInterface::class);
$storeManager->setCurrentStore(IMPORT_STORE_ID);

// Sanity-check that IMPORT_STORE_ID actually exists on this instance.
$availableStoreIds = array_keys($storeManager->getStores());
if (!in_array(IMPORT_STORE_ID, $availableStoreIds, true)) {
    die(
        "ERROR: IMPORT_STORE_ID (" . IMPORT_STORE_ID . ") is not a valid store view ID.\n" .
        "Available store view IDs on this instance: " . implode(', ', $availableStoreIds) . "\n" .
        "Edit the IMPORT_STORE_ID constant near the top of this script and try again.\n"
    );
}

$otherStoreIds = array_values(array_diff($availableStoreIds, [IMPORT_STORE_ID]));
echo "Store views on this instance: " . implode(', ', $availableStoreIds) . "\n";
echo "Primary save scope: " . IMPORT_STORE_ID . ". "
    . (PROPAGATE_TO_ALL_STORES
        ? "Will also propagate name/description to: " . implode(', ', $otherStoreIds) . "\n"
        : "Propagation to other stores is OFF.\n");

// ----------------------------------------------------------------------
// 3. Read and validate the CSV
// ----------------------------------------------------------------------
if (!file_exists(CSV_FILE)) {
    die("ERROR: CSV file not found at " . CSV_FILE . "\n");
}

$fp = fopen(CSV_FILE, 'r');
if ($fp === false) {
    die("ERROR: Could not open CSV file for reading.\n");
}

$header = fgetcsv($fp);
$expectedHeader = ['entity_id', 'name', 'url_key', 'is_active', 'parent_id', 'path', 'level', 'description'];
if ($header !== $expectedHeader) {
    echo "WARNING: CSV header does not match expected columns.\n";
    echo "Expected: " . implode(', ', $expectedHeader) . "\n";
    echo "Found:    " . implode(', ', $header) . "\n";
    echo "Proceeding anyway, assuming column order matches expected...\n\n";
}

$rows = [];
while (($data = fgetcsv($fp)) !== false) {
    if (count($data) !== count($expectedHeader)) {
        echo "SKIPPING malformed row (wrong column count): " . implode(',', array_slice($data, 0, 2)) . "\n";
        continue;
    }
    $rows[] = array_combine($expectedHeader, $data);
}
fclose($fp);

echo "Loaded " . count($rows) . " rows from CSV.\n";

// Sort by level ascending so parents are always created before children,
// regardless of the order rows appear in the CSV.
usort($rows, function ($a, $b) {
    return ((int) $a['level']) <=> ((int) $b['level']);
});

// ----------------------------------------------------------------------
// 4. Walk the tree top-down and create categories on FRESH
// ----------------------------------------------------------------------
$idMap = []; // live entity_id => new fresh category_id
$skipped = [];
$created = 0;

foreach ($rows as $row) {
    $liveId = (int) $row['entity_id'];
    $level = (int) $row['level'];
    $liveParentId = (int) $row['parent_id'];

    // Skip level 0 (absolute root) and level 1 (live's default root) —
    // fresh already has its own equivalents.
    if ($level <= 1) {
        $idMap[$liveId] = FRESH_TARGET_ROOT_ID;
        continue;
    }

    $newParentId = $idMap[$liveParentId] ?? null;
    if ($newParentId === null) {
        echo "SKIP live #{$liveId} ({$row['name']}): parent live #{$liveParentId} was not created (not found or itself skipped).\n";
        $skipped[] = $liveId;
        continue;
    }

    if (empty($row['name'])) {
        echo "SKIP live #{$liveId}: empty name.\n";
        $skipped[] = $liveId;
        continue;
    }

    if (DRY_RUN) {
        echo "[DRY RUN] Would create: {$row['name']} (live #{$liveId}) under fresh parent #{$newParentId}\n";
        // Fake an ID so children can still resolve their parent in dry-run mode
        $idMap[$liveId] = "DRYRUN-{$liveId}";
        $created++;
        continue;
    }

    try {
        /** @var Category $category */
        $category = $categoryFactory->create();
        // Use a REAL store view scope, not admin/"All Store Views" (0) —
        // saving in scope 0 triggers a Magento core validation bug on
        // multi-store-view instances (magento/magento2#22309).
        $category->setStoreId(IMPORT_STORE_ID);
        $category->setName($row['name']);
        $category->setParentId($newParentId);
        $category->setIsActive($row['is_active'] === '' ? true : (bool) (int) $row['is_active']);
        $category->setDisplayMode('PRODUCTS');
        $category->setIsAnchor(true);

        if (!empty($row['url_key'])) {
            $category->setUrlKey($row['url_key']);
        }
        if (!empty($row['description'])) {
            $category->setCustomAttribute('description', $row['description']);
        }

        $categoryRepository->save($category);
        $idMap[$liveId] = (int) $category->getId();
        $created++;

        echo "Created: {$row['name']} (live #{$liveId} -> fresh #{$category->getId()})\n";

        // Propagate to other store views so every storefront shows this
        // category correctly, not just IMPORT_STORE_ID's.
        if (PROPAGATE_TO_ALL_STORES) {
            foreach ($otherStoreIds as $otherStoreId) {
                try {
                    $storeCategory = $categoryRepository->get($category->getId(), $otherStoreId);
                    $storeCategory->setStoreId($otherStoreId);
                    $storeCategory->setName($row['name']);
                    if (!empty($row['url_key'])) {
                        $storeCategory->setUrlKey($row['url_key']);
                    }
                    if (!empty($row['description'])) {
                        $storeCategory->setCustomAttribute('description', $row['description']);
                    }
                    $categoryRepository->save($storeCategory);
                } catch (\Throwable $e) {
                    echo "  WARNING: could not propagate to store {$otherStoreId} for live #{$liveId}: " . $e->getMessage() . "\n";
                }
            }
        }
    } catch (\Throwable $e) {
        echo "FAILED live #{$liveId} ({$row['name']}): " . $e->getMessage() . "\n";
        $skipped[] = $liveId;
    }
}

// ----------------------------------------------------------------------
// 5. Summary
// ----------------------------------------------------------------------
echo "\n----------------------------------------\n";
echo (DRY_RUN ? "[DRY RUN] " : "") . "Done. Created: {$created}. Skipped: " . count($skipped) . "\n";
if ($skipped) {
    echo "Skipped live IDs: " . implode(', ', $skipped) . "\n";
}
if (!DRY_RUN) {
    echo "\nNow run:\n";
    echo "  bin/magento indexer:reindex\n";
    echo "  bin/magento cache:flush\n";
} else {
    echo "\nThis was a dry run — nothing was saved. Set DRY_RUN = false to actually import.\n";
}
