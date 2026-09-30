<?php
namespace TJV\PromoShipping\Helper;

use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class PromoHelper extends AbstractHelper
{
    private const XML_PATH_TRIGGER_CATEGORIES = 'tjv_promo/buy_one_free_shipping/trigger_categories';
    private const XML_PATH_FREE_SHIPPING_CATEGORIES = 'tjv_promo/buy_one_free_shipping/free_shipping_categories';
    private const XML_PATH_ENABLED = 'tjv_promo/buy_one_free_shipping/enabled';

    /** @var CategoryCollectionFactory */
    private CategoryCollectionFactory $categoryCollectionFactory;

    /** @var array */
    private array $expandedCache = [];

    /** @var array */
    private array $productCategoryCache = [];

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param CategoryCollectionFactory $categoryCollectionFactory
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        CategoryCollectionFactory $categoryCollectionFactory
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
    }

    /**
     * Check whether the promotion is enabled for a store.
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isEnabled(?int $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Return trigger category IDs (selected categories plus their subcategories).
     *
     * @param int|null $storeId
     * @return int[]
     */
    public function getTriggerCategoryIds(?int $storeId = null): array
    {
        return $this->getCategoryIdsWithChildren(self::XML_PATH_TRIGGER_CATEGORIES, $storeId);
    }

    /**
     * Return free-shipping category IDs (selected categories plus their subcategories).
     *
     * @param int|null $storeId
     * @return int[]
     */
    public function getFreeShippingCategoryIds(?int $storeId = null): array
    {
        return $this->getCategoryIdsWithChildren(self::XML_PATH_FREE_SHIPPING_CATEGORIES, $storeId);
    }

    /**
     * Check whether a quote item (or its child product) belongs to any of the given categories.
     *
     * @param \Magento\Quote\Model\Quote\Item\AbstractItem $item
     * @param int[] $categoryIds
     * @return bool
     */
    public function matchesCategories($item, array $categoryIds): bool
    {
        if (!$categoryIds) {
            return false;
        }

        return (bool)array_intersect($this->getItemCategoryIds($item), $categoryIds);
    }

    /**
     * Collect category IDs of the item's product and its children (configurable simples).
     *
     * @param \Magento\Quote\Model\Quote\Item\AbstractItem $item
     * @return int[]
     */
    private function getItemCategoryIds($item): array
    {
        $products = [$item->getProduct()];
        foreach ((array)$item->getChildren() as $child) {
            $products[] = $child->getProduct();
        }

        $ids = [];
        foreach ($products as $product) {
            if (!$product || !$product->getId()) {
                continue;
            }
            $productId = (int)$product->getId();
            if (!isset($this->productCategoryCache[$productId])) {
                $this->productCategoryCache[$productId] = array_map('intval', $product->getCategoryIds());
            }
            $ids = array_merge($ids, $this->productCategoryCache[$productId]);
        }

        return array_values(array_unique($ids));
    }

    /**
     * Read a multiselect category config and expand it with all descendant categories.
     *
     * @param string $path
     * @param int|null $storeId
     * @return int[]
     */
    private function getCategoryIdsWithChildren(string $path, ?int $storeId): array
    {
        $cacheKey = $path . '|' . (string)$storeId;
        if (isset($this->expandedCache[$cacheKey])) {
            return $this->expandedCache[$cacheKey];
        }

        $raw = (string)$this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE, $storeId);
        $ids = array_values(array_filter(array_map('intval', explode(',', $raw))));
        if (!$ids) {
            return $this->expandedCache[$cacheKey] = [];
        }

        $selected = $this->categoryCollectionFactory->create();
        $selected->addFieldToFilter('entity_id', ['in' => $ids]);

        $conditions = [];
        foreach ($selected as $category) {
            $conditions[] = ['like' => $category->getPath() . '/%'];
        }

        if ($conditions) {
            $children = $this->categoryCollectionFactory->create();
            $children->addFieldToFilter('path', $conditions); // array of conditions = OR
            foreach ($children as $child) {
                $ids[] = (int)$child->getId();
            }
        }

        return $this->expandedCache[$cacheKey] = array_values(array_unique($ids));
    }
}