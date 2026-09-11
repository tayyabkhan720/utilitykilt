<?php
declare(strict_types=1);

namespace TJV\ProductLists\Block;

use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Helper\Product\Compare as CompareHelper;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Helper\ImageFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Data\Helper\PostHelper;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Wishlist\Helper\Data as WishlistHelper;

class ProductList extends Template
{
    /**
     * Popular Product IDs.
     */
    private const POPULAR_PRODUCT_IDS = [
        390, 379, 381
    ];

    /**
     * Most Sale Product IDs.
     */
    private const MOST_SALE_PRODUCT_IDS = [
        201,
        202,
        203,
    ];

    private const BUNDLE_PRODUCT_IDS = [
    301,
    302,
    303,
];

    /**
     * Magento Review entity type.
     *
     * Product reviews use entity_type = 1.
     */
    private const REVIEW_ENTITY_TYPE_PRODUCT = 1;

    public function __construct(
        Template\Context $context,
        private readonly CollectionFactory $productCollectionFactory,
        private readonly CategoryFactory $categoryFactory,
        private readonly ImageFactory $imageFactory,
        private readonly WishlistHelper $wishlistHelper,
        private readonly CompareHelper $compareHelper,
        private readonly PostHelper $postHelper,
        private readonly StoreManagerInterface $storeManager,
        private readonly PriceCurrencyInterface $priceCurrency,
        private readonly ResourceConnection $resourceConnection,
        private readonly ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Get products based on the requested product list.
     *
     * @param string $type
     * @return Product[]
     */
    public function getProducts(string $type): array
    {
        $ids = $type === 'most_sale'
                ? self::MOST_SALE_PRODUCT_IDS
                : ($type === 'bundle'
                    ? self::BUNDLE_PRODUCT_IDS
                    : self::POPULAR_PRODUCT_IDS);

        if (empty($ids)) {
            return [];
        }

        $storeId = (int) $this->storeManager->getStore()->getId();

        $collection = $this->productCollectionFactory->create();

        $collection->addAttributeToSelect([
            'name',
            'price',
            'special_price',
            'special_from_date',
            'special_to_date',
            'small_image',
            'thumbnail',
            'url_key',

        ]);

        $collection->addIdFilter($ids);

        // Scope store-view attributes without filtering by website assignment.
        // The IDs are explicitly curated for this list and may belong to another
        // website in installations with multiple storefronts.
        $collection->setStoreId($storeId);
        $collection->addUrlRewrite();

        /**
         * Add review rating and review count.
         *
         * Magento stores this information in:
         *
         * review_entity_summary
         *
         * We join it directly instead of using ReviewFactory.
         */
        $reviewSummaryTable = $this->resourceConnection
            ->getTableName('review_entity_summary');

        $collection->getSelect()->joinLeft(
            ['review_summary' => $reviewSummaryTable],
            'review_summary.entity_pk_value = e.entity_id'
            . ' AND review_summary.entity_type = '
            . self::REVIEW_ENTITY_TYPE_PRODUCT
            . ' AND review_summary.store_id = ' . $storeId,
            [
                'rating_summary' => 'review_summary.rating_summary',
                'reviews_count' => 'review_summary.reviews_count',
            ]
        );

        $collection->load();

        /**
         * Keep the same order as the static ID array.
         */
        $products = [];

        foreach ($ids as $id) {
            $product = $collection->getItemById((int) $id);

            if ($product && $product->getId()) {
                $products[] = $product;
            }
        }

        return $products;
    }

    /**
     * Get parent category name.
     *
     * Example:
     *
     * Tartan Kilt
     *     └── Classic Tartan Kilt
     *
     * Returns:
     *
     * Tartan Kilt
     */
    public function getParentCategoryName(Product $product): string
    {
        $categoryIds = $product->getCategoryIds();

        if (empty($categoryIds)) {
            return '';
        }

        /**
         * Get the deepest category assigned to the product.
         */
        $categoryCollection = $this->categoryFactory->create()
            ->getCollection()
            ->addAttributeToSelect([
                'name',
                'parent_id',
                'level',
            ])
            ->addIdFilter($categoryIds)
            ->setOrder('level', 'DESC');

        $category = $categoryCollection->getFirstItem();

        if (!$category || !$category->getId()) {
            return '';
        }

        $parentId = (int) $category->getParentId();

        if (!$parentId) {
            return '';
        }

        /**
         * Load parent category.
         */
        $parentCategory = $this->categoryFactory->create()
            ->load($parentId);

        if (!$parentCategory->getId()) {
            return '';
        }

        return (string) $parentCategory->getName();
    }

    /**
     * Format price using current store currency.
     */
    public function getFormattedPrice(float $price): string
    {
        return $this->priceCurrency->format(
            $price,
            false,
            PriceCurrencyInterface::DEFAULT_PRECISION,
            $this->storeManager->getStore()
        );
    }

    /**
     * Calculate discount percentage.
     *
     * Example:
     *
     * Regular price = £295
     * Final price   = £179.98
     *
     * Result = 39%
     */
    public function getDiscountPercent(Product $product): int
    {
        $regularPrice = (float) $product->getPrice();
        $finalPrice = (float) $product->getFinalPrice();

        if ($regularPrice <= 0 || $finalPrice >= $regularPrice) {
            return 0;
        }

        return (int) round(
            (($regularPrice - $finalPrice) / $regularPrice) * 100
        );
    }

    /**
     * Check whether product has a discount.
     */
    public function hasDiscount(Product $product): bool
    {
        return $this->getDiscountPercent($product) > 0;
    }

    /**
     * Get product URL.
     */
    public function getProductUrl(Product $product): string
    {
        $url = (string) $product->getProductUrl();

        if (
            !str_contains($url, '/catalog/product/view')
            || !$product->getUrlKey()
        ) {
            return $url;
        }

        $suffix = (string) $this->scopeConfig->getValue(
            'catalog/seo/product_url_suffix',
            ScopeInterface::SCOPE_STORE,
            (int) $this->storeManager->getStore()->getId()
        );

        return rtrim($this->storeManager->getStore()->getBaseUrl(), '/')
            . '/'
            . ltrim((string) $product->getUrlKey() . $suffix, '/');
    }

    /**
     * Get the add-to-cart URL and post payload used by Magento's product actions.
     */
    public function getAddToCartUrl(Product $product): string
    {
        return (string) $this->compareHelper->getAddToCartUrl($product);
    }

    public function getAddToCartPostData(Product $product): string
    {
        return $this->postHelper->getPostData(
            $this->getAddToCartUrl($product),
            ['product' => (int) $product->getId()]
        );
    }

    public function getAddToWishlistParams(Product $product): string
    {
        return $this->compareHelper->getAddToWishlistParams($product);
    }

    public function getAddToCompareParams(Product $product): string
    {
        return $this->compareHelper->getPostDataParams($product);
    }

    public function isWishlistAllowed(): bool
    {
        return $this->wishlistHelper->isAllow();
    }

    /**
     * Get the product image URL for the homepage card.
     */
    public function getProductImageUrl(Product $product): string
    {
        return (string) $this->imageFactory
            ->create()
            ->init($product, 'category_page_grid')
            ->getUrl();
    }

    /**
     * Get rating summary.
     *
     * Magento returns rating as a percentage:
     *
     * 0 - 100
     */
    public function getRatingSummary(Product $product): float
    {
        return (float) $product->getData('rating_summary');
    }

    /**
     * Get review count.
     */
    public function getReviewsCount(Product $product): int
    {
        return (int) $product->getData('reviews_count');
    }
}