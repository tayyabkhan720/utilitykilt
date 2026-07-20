<?php
/**
 * Copyright © Ops. All rights reserved.
 */
namespace Ops\MeasuringGuide\Block\Product;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Helper\Image;
use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Category as CategoryResource;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

/**
 * Measuring Guide Block for Product Pages
 * Pulls content from product's category
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
     * @var CategoryFactory
     */
    protected $categoryFactory;


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
     * @param ProductRepositoryInterface $productRepository
     * @param Image $imageHelper
     * @param CategoryFactory $categoryFactory
     * @param LoggerInterface $logger
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ScopeConfigInterface $scopeConfig,
        CategoryResource $categoryResource,
        ProductRepositoryInterface $productRepository,
        Image $imageHelper,
        CategoryFactory $categoryFactory,
        LoggerInterface $logger,
        array $data = []
    ) {
        $this->registry = $registry;
        $this->scopeConfig = $scopeConfig;
        $this->categoryResource = $categoryResource;
        $this->productRepository = $productRepository;
        $this->imageHelper = $imageHelper;
        $this->categoryFactory = $categoryFactory;
        $this->logger = $logger;
        parent::__construct($context, $data);
    }

    /**
     * Get current product
     *
     * @return Product|null
     */
    public function getCurrentProduct()
    {
        return $this->registry->registry('current_product');
    }

    /**
     * Get product's category with measuring guide enabled
     * Checks all assigned categories to find one with measuring guide enabled
     *
     * @return Category|null
     */
    public function getProductCategory()
    {
        $product = $this->getCurrentProduct();
        if (!$product || !$product->getId()) {
            return null;
        }

        $categoryIds = $product->getCategoryIds();
        if (empty($categoryIds)) {
            return null;
        }

        $storeId = $this->_storeManager->getStore()->getId();
        
        // Check all categories to find one with measuring guide enabled
        foreach ($categoryIds as $categoryId) {
            try {
                $category = $this->categoryFactory->create();
                $category->setStoreId($storeId);
                $this->categoryResource->load($category, $categoryId);
                
                if ($category && $category->getId()) {
                    // Check if this category has measuring guide enabled
                    $categoryEnabled = (bool)$this->categoryResource->getAttributeRawValue(
                        $categoryId,
                        'enable_measuring_guide',
                        $storeId
                    );
                    
                    $hasContent = !empty($this->categoryResource->getAttributeRawValue(
                        $categoryId,
                        'measuring_guide_content',
                        $storeId
                    ));
                    
                    // Return the first category that has measuring guide enabled and content
                    if ($categoryEnabled && $hasContent) {
                        return $category;
                    }
                }
            } catch (\Exception $e) {
                $this->logger->error('Measuring Guide: Error loading category', [
                    'category_id' => $categoryId,
                    'error' => $e->getMessage()
                ]);
                continue;
            }
        }
        
        // If no category with measuring guide found, return the first category
        // This allows the guide to show if content is added later
        try {
            $categoryId = reset($categoryIds);
            $category = $this->categoryFactory->create();
            $category->setStoreId($storeId);
            $this->categoryResource->load($category, $categoryId);
            if ($category && $category->getId()) {
                return $category;
            }
        } catch (\Exception $e) {
            $this->logger->error('Measuring Guide: Error loading first category', [
                'category_id' => $categoryId,
                'error' => $e->getMessage()
            ]);
        }

        return null;
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
        
        $category = $this->getProductCategory();
        if (!$category || !$category->getId()) {
            return false;
        }

        $categoryId = $category->getId();
        $storeId = $this->_storeManager->getStore()->getId();

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
     * Get measuring guide content from product's category
     *
     * @return string|null
     */
    public function getMeasuringGuideContent()
    {
        $category = $this->getProductCategory();
        if (!$category || !$category->getId()) {
            return null;
        }
        
        $categoryId = $category->getId();
        $storeId = $this->_storeManager->getStore()->getId();
        
        // Load attribute directly from resource model
        $content = $this->categoryResource->getAttributeRawValue(
            $categoryId,
            'measuring_guide_content',
            $storeId
        );
        
        // Ensure we return a string
        $content = is_string($content) ? $content : (is_array($content) ? '' : (string)$content);
        
        // Clean up Page Builder wrapper divs that might break HTML structure
        if (!empty($content)) {
            // Remove Page Builder wrapper: <div data-content-type="html">...</div>
            $content = preg_replace('/<div[^>]*data-content-type="html"[^>]*>(.*?)<\/div>/s', '$1', $content);
            // Decode HTML entities
            $content = html_entity_decode($content, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            // Trim whitespace
            $content = trim($content);
        }
        
        return $content;
    }

    /**
     * Get products from category for measuring guide
     * Uses products already assigned to the category (from "Products in Category")
     *
     * @return \Magento\Catalog\Api\Data\ProductInterface[]
     */
    public function getAssignedProducts()
    {
        $category = $this->getProductCategory();
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

    /**
     * Parse measuring guide content for structured display
     * Similar to FAQ parsing - extracts sections if needed
     *
     * @return array
     */
    public function getMeasuringGuideSections()
    {
        $content = $this->getMeasuringGuideContent();
        if (!$content) {
            return [];
        }

        // Decode HTML entities
        $content = html_entity_decode($content, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        
        // Remove Page Builder wrapper if present
        $content = preg_replace('/<div[^>]*data-content-type="html"[^>]*>(.*?)<\/div>/s', '$1', $content);
        
        // Clean up any remaining wrapper tags
        $content = trim($content);

        // If content has structured sections (like FAQ format), parse them
        // Otherwise, return as single section
        $sections = [];
        
        // Try to parse structured format (similar to FAQ)
        preg_match_all('/<strong>(.*?)<\/strong>\s*(?:<p>)?(.*?)(?:<\/p>)?/s', $content, $matches, PREG_SET_ORDER);
        
        if (!empty($matches)) {
            foreach ($matches as $match) {
                if (isset($match[1]) && isset($match[2])) {
                    $sections[] = [
                        'title' => trim(strip_tags($match[1])),
                        'content' => trim($match[2])
                    ];
                }
            }
        } else {
            // Return as single section
            $sections[] = [
                'title' => '',
                'content' => $content
            ];
        }

        return $sections;
    }
}

