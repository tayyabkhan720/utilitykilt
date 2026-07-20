<?php
/**
 * Copyright © Ops. All rights reserved.
 */
namespace Ops\MeasuringGuide\Block;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Helper\Image;
use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\ResourceModel\Category as CategoryResource;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

/**
 * Measuring Guide Block for Category Pages
 */
class MeasuringGuide extends Template
{
    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var CategoryResource
     */
    protected $categoryResource;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var Image
     */
    protected $imageHelper;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param ScopeConfigInterface $scopeConfig
     * @param CategoryResource $categoryResource
     * @param StoreManagerInterface $storeManager
     * @param ProductRepositoryInterface $productRepository
     * @param Image $imageHelper
     * @param LoggerInterface $logger
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ScopeConfigInterface $scopeConfig,
        CategoryResource $categoryResource,
        StoreManagerInterface $storeManager,
        ProductRepositoryInterface $productRepository,
        Image $imageHelper,
        LoggerInterface $logger,
        array $data = []
    ) {
        $this->registry = $registry;
        $this->scopeConfig = $scopeConfig;
        $this->categoryResource = $categoryResource;
        $this->storeManager = $storeManager;
        $this->productRepository = $productRepository;
        $this->imageHelper = $imageHelper;
        $this->logger = $logger;
        parent::__construct($context, $data);
    }

    /**
     * Get current category
     *
     * @return Category|null
     */
    public function getCurrentCategory()
    {
        return $this->registry->registry('current_category');
    }

    /**
     * Check if global measuring guide is enabled
     *
     * @return bool
     */
    public function isGlobalMeasuringGuideEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            'measuringguide/general/enable_all_measuring_guide',
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Check if measuring guide should be displayed
     *
     * @return bool
     */
    public function shouldDisplayMeasuringGuide()
    {
        $globalEnabled = $this->isGlobalMeasuringGuideEnabled();
        
        $category = $this->getCurrentCategory();
        if (!$category || !$category->getId()) {
            return false;
        }

        $categoryId = $category->getId();
        $storeId = $this->storeManager->getStore()->getId();

        // Load attributes directly from resource model
        $categoryEnabled = (bool)$this->categoryResource->getAttributeRawValue(
            $categoryId,
            'enable_measuring_guide',
            $storeId
        );
        
        $measuringGuideContent = $this->categoryResource->getAttributeRawValue(
            $categoryId,
            'measuring_guide_content',
            $storeId
        );

        // Ensure $measuringGuideContent is a string
        $measuringGuideContent = is_string($measuringGuideContent) ? $measuringGuideContent : '';
        $hasContent = !empty(trim($measuringGuideContent));
        $shouldDisplay = $globalEnabled && $categoryEnabled && $hasContent;

        return $shouldDisplay;
    }

    /**
     * Get measuring guide content from category
     *
     * @return string|null
     */
    public function getMeasuringGuideContent()
    {
        $category = $this->getCurrentCategory();
        if (!$category || !$category->getId()) {
            return null;
        }
        
        $categoryId = $category->getId();
        $storeId = $this->storeManager->getStore()->getId();
        
        // Load attribute directly from resource model
        $content = $this->categoryResource->getAttributeRawValue(
            $categoryId,
            'measuring_guide_content',
            $storeId
        );
        
        // Ensure we return a string
        return is_string($content) ? $content : (is_array($content) ? '' : (string)$content);
    }

    /**
     * Get products from category for measuring guide
     * Uses products already assigned to the category (from "Products in Category")
     *
     * @return \Magento\Catalog\Api\Data\ProductInterface[]
     */
    public function getAssignedProducts()
    {
        $category = $this->getCurrentCategory();
        if (!$category || !$category->getId()) {
            return [];
        }

        try {
            // Ensure category is fully loaded
            if (!$category->hasData('product_collection')) {
                $category->load($category->getId());
            }

            // Get product collection from category
            $productCollection = $category->getProductCollection();
            $productCollection->addAttributeToSelect(['name', 'sku', 'small_image', 'price', 'status', 'visibility']);
            $productCollection->addAttributeToFilter('status', \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED);
            $productCollection->addAttributeToFilter('visibility', ['in' => [
                \Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH,
                \Magento\Catalog\Model\Product\Visibility::VISIBILITY_IN_CATALOG,
                \Magento\Catalog\Model\Product\Visibility::VISIBILITY_IN_SEARCH
            ]]);
            $productCollection->setOrder('position', 'ASC');
            $productCollection->setPageSize(20); // Limit to 20 products

            return $productCollection->getItems();
        } catch (\Exception $e) {
            $this->logger->error('Measuring Guide: Error loading category products', [
                'category_id' => $category->getId(),
                'error' => $e->getMessage()
            ]);
            return [];
        }
    }

    /**
     * Get image helper
     *
     * @return Image
     */
    public function getImageHelper()
    {
        return $this->imageHelper;
    }
}

