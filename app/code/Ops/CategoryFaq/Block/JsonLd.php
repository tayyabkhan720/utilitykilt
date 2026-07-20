<?php
/**
 * Copyright © Ops. All rights reserved.
 */
namespace Ops\CategoryFaq\Block;

use Amasty\SeoRichData\Block\JsonLd as AmastyJsonLd;
use Amasty\SeoRichData\Model\DataCollector;
use Magento\Framework\Registry;
use Magento\Store\Model\StoreManagerInterface;
use Amasty\SeoRichData\Helper\Category as CategoryHelper;
use Magento\Framework\Json\EncoderInterface;
use Magento\Framework\View\Page\Config as PageConfig;
use Amasty\SeoRichData\Helper\Config as ConfigHelper;
use Magento\Catalog\Model\Layer\Resolver as LayerResolver;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Catalog\Model\ResourceModel\Category as CategoryResource;
use Magento\Store\Model\ScopeInterface;

/**
 * Safe override of Amasty's JsonLd block
 * Adds FAQ schema to the data array so it's output in the same loop
 */
class JsonLd extends AmastyJsonLd
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var CategoryResource
     */
    protected $categoryResource;

    /**
     * Constructor - must match parent exactly
     */
    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        DataCollector $dataCollector,
        Registry $coreRegistry,
        StoreManagerInterface $storeManager,
        CategoryHelper $categoryHelper,
        EncoderInterface $jsonEncoder,
        PageConfig $pageConfig,
        ConfigHelper $configHelper,
        LayerResolver $layerResolver,
        array $data = []
    ) {
        // Call parent constructor
        parent::__construct(
            $context,
            $dataCollector,
            $coreRegistry,
            $storeManager,
            $categoryHelper,
            $jsonEncoder,
            $pageConfig,
            $configHelper,
            $layerResolver,
            $data
        );

        // Use ObjectManager for our dependencies to avoid DI issues
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $this->scopeConfig = $objectManager->get(ScopeConfigInterface::class);
        $this->categoryResource = $objectManager->get(CategoryResource::class);
    }

    /**
     * Override prepareData to add FAQ schema to the data array
     * This adds FAQ to Amasty's output loop
     *
     * @return array
     */
    protected function prepareData()
    {
        // Get Amasty's data first
        $data = [];
        
        try {
            // Call parent's prepareData safely
            $data = parent::prepareData();
            if (!is_array($data)) {
                $data = [];
            }
        } catch (\Throwable $e) {
            // If parent fails, return empty array - page will still load
            $data = [];
        }

        // Filter schemas based on page type
        // WebSite schema should be removed from ALL pages (homepage, category, product)
        // Organization should ONLY appear on homepage
        // BreadcrumbList should appear on ALL pages (homepage, category, product)
        
        // Remove WebSite schema from all pages
        if (isset($data['website'])) {
            unset($data['website']);
        }
        
        // Remove Organization schema from non-homepage pages (category, product, CMS)
        if (!$this->isHomePage()) {
            if (isset($data['organization'])) {
                unset($data['organization']);
            }
        }
        
        // Also check for variations in key names and nested structures
        foreach ($data as $key => $value) {
            if (is_array($value) && isset($value['@type'])) {
                // Remove WebSite schema from all pages
                if ($value['@type'] === 'WebSite') {
                    unset($data[$key]);
                }
                // Remove Organization schema from non-homepage pages
                if (!$this->isHomePage() && $value['@type'] === 'Organization') {
                    unset($data[$key]);
                }
                // Preserve BreadcrumbList on all pages - do not remove
                // BreadcrumbList should appear on homepage, category, and product pages
            }
        }
        
        // Ensure BreadcrumbList is present on homepage if Amasty provides it
        // If Amasty doesn't provide BreadcrumbList on homepage, it might be a configuration issue
        // We preserve whatever Amasty provides, we just don't remove it

        // Add Category schema for category pages
        try {
            $categorySchema = $this->getCollectionPageSchema($data);
            if ($categorySchema && is_array($categorySchema) && !empty($categorySchema)) {
                // Add Category schema to data array
                $data['category_schema'] = $categorySchema;
            }
        } catch (\Throwable $e) {
            // Ignore errors
        }

        // Ensure BreadcrumbList is present on homepage if Amasty doesn't provide it
        if ($this->isHomePage()) {
            $hasBreadcrumbList = false;
            foreach ($data as $key => $value) {
                if (is_array($value) && isset($value['@type']) && $value['@type'] === 'BreadcrumbList') {
                    $hasBreadcrumbList = true;
                    break;
                }
            }
            
            // If BreadcrumbList doesn't exist, try to add it
            if (!$hasBreadcrumbList) {
                try {
                    // First try Amasty's method if it exists
                    if (method_exists($this, 'addBreadcrumbsData')) {
                        $this->addBreadcrumbsData($data);
                        // Check again if it was added
                        foreach ($data as $key => $value) {
                            if (is_array($value) && isset($value['@type']) && $value['@type'] === 'BreadcrumbList') {
                                $hasBreadcrumbList = true;
                                break;
                            }
                        }
                    }
                    
                    // If still not present, create a simple BreadcrumbList for homepage
                    if (!$hasBreadcrumbList) {
                        $breadcrumbSchema = $this->getHomepageBreadcrumbSchema();
                        if ($breadcrumbSchema && is_array($breadcrumbSchema) && !empty($breadcrumbSchema)) {
                            $data['breadcrumb'] = $breadcrumbSchema;
                        }
                    }
                } catch (\Throwable $e) {
                    // If all methods fail, try to create basic breadcrumb
                    try {
                        $breadcrumbSchema = $this->getHomepageBreadcrumbSchema();
                        if ($breadcrumbSchema && is_array($breadcrumbSchema) && !empty($breadcrumbSchema)) {
                            $data['breadcrumb'] = $breadcrumbSchema;
                        }
                    } catch (\Throwable $e2) {
                        // Fail silently
                    }
                }
            }
        }

        // Add FAQ schema ONLY on category pages where FAQ is enabled
        // Do NOT add on homepage, product pages, CMS pages, or any other pages
        try {
            if ($this->isCategoryPage() && !$this->isHomePage() && !$this->isProductPage() && !$this->isCmsPage()) {
                $faqSchema = $this->getFaqSchemaData();
                if ($faqSchema && is_array($faqSchema) && !empty($faqSchema)) {
                    // Add FAQ to data array - it will be output in the same loop as other schemas
                    $data['faq'] = $faqSchema;
                }
            }
        } catch (\Throwable $e) {
            // Ignore errors
        }

        return $data;
    }

    /**
     * Get Category schema for category pages
     *
     * @param array $data Existing data array from parent
     * @return array|null
     */
    protected function getCollectionPageSchema(array $data = [])
    {
        try {
            // Only process on category pages
            $category = $this->coreRegistry->registry('current_category');
            if (!$category || !$category->getId()) {
                return null;
            }

            // Check if we're on a category page using full action name
            if (!$this->isCategoryPage()) {
                return null;
            }

            // Build CollectionPage schema (correct Schema.org type for category pages)
            $schema = [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => $category->getName(),
                'url' => $category->getUrl()
            ];

            // Add description if available
            $description = $category->getDescription();
            if ($description && !empty(trim(strip_tags($description)))) {
                $schema['description'] = strip_tags($description);
            }

            // Add image if available
            $imageUrl = $category->getImageUrl();
            if ($imageUrl) {
                $schema['image'] = $imageUrl;
            }

            // Add mainEntity with ItemList of products if available from Amasty
            if (isset($data['category']) && is_array($data['category']) && !empty($data['category'])) {
                $schema['mainEntity'] = [
                    '@type' => 'ItemList',
                    'name' => $category->getName() . ' Products',
                    'itemListElement' => []
                ];

                foreach ($data['category'] as $index => $product) {
                    if (is_array($product) && isset($product['@type']) && $product['@type'] === 'Product') {
                        $schema['mainEntity']['itemListElement'][] = [
                            '@type' => 'ListItem',
                            'position' => $index + 1,
                            'item' => $product
                        ];
                    }
                }
            }

            return $schema;
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Check if current page is a category page
     *
     * @return bool
     */
    protected function isCategoryPage()
    {
        if (!$this->_request) {
            return false;
        }
        
        $fullActionName = $this->_request->getFullActionName();
        return $fullActionName === 'catalog_category_view';
    }

    /**
     * Check if current page is the homepage
     *
     * @return bool
     */
    protected function isHomePage()
    {
        if (!$this->_request) {
            return false;
        }
        
        $fullActionName = $this->_request->getFullActionName();
        return $fullActionName === 'cms_index_index';
    }

    /**
     * Check if current page is a product page
     *
     * @return bool
     */
    protected function isProductPage()
    {
        if (!$this->_request) {
            return false;
        }
        
        $fullActionName = $this->_request->getFullActionName();
        return $fullActionName === 'catalog_product_view';
    }

    /**
     * Check if current page is a CMS page
     *
     * @return bool
     */
    protected function isCmsPage()
    {
        if (!$this->_request) {
            return false;
        }
        
        $fullActionName = $this->_request->getFullActionName();
        return $fullActionName === 'cms_page_view';
    }

    /**
     * Get FAQ schema data
     * Only returns FAQ schema if:
     * - We're on a category page
     * - FAQ is enabled globally
     * - FAQ is enabled for the category
     * - FAQ content exists and can be parsed
     *
     * @return array|null
     */
    protected function getFaqSchemaData()
    {
        try {
            // Double-check we're on a category page (safety check)
            if (!$this->isCategoryPage()) {
                return null;
            }

            // Get current category
            $category = $this->coreRegistry->registry('current_category');
            if (!$category || !$category->getId()) {
                return null;
            }

            // Check if FAQ is enabled globally
            $globalEnabled = $this->scopeConfig->isSetFlag(
                'categoryfaq/general/enable_all_faq',
                ScopeInterface::SCOPE_STORE
            );
            if (!$globalEnabled) {
                return null;
            }

            $storeId = $this->storeManager->getStore()->getId();
            $categoryId = $category->getId();

            // Check if FAQ is enabled for this category
            $categoryEnabled = (bool)$this->categoryResource->getAttributeRawValue(
                $categoryId,
                'enable_faq',
                $storeId
            );
            if (!$categoryEnabled) {
                return null;
            }

            // Get FAQ content
            $faqContent = $this->categoryResource->getAttributeRawValue(
                $categoryId,
                'category_faq',
                $storeId
            );
            if (empty($faqContent) || !is_string($faqContent)) {
                return null;
            }

            // Parse FAQ content
            $faqItems = $this->parseFaqContent($faqContent);
            if (empty($faqItems)) {
                return null;
            }

            // Build FAQ schema
            return $this->buildFaqSchema($faqItems);
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Build FAQPage schema structure
     *
     * @param array $faqItems
     * @return array
     */
    protected function buildFaqSchema(array $faqItems)
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => []
        ];

        foreach ($faqItems as $item) {
            if (empty($item['question']) || empty($item['answer'])) {
                continue;
            }

            $schema['mainEntity'][] = [
                '@type' => 'Question',
                'name' => $item['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => strip_tags($item['answer'])
                ]
            ];
        }

        return $schema;
    }

    /**
     * Parse FAQ content HTML into structured array
     * Handles multiple HTML formats
     *
     * @param string $faqContent
     * @return array
     */
    protected function parseFaqContent($faqContent)
    {
        $faqItems = [];

        try {
            // Decode HTML entities
            $faqContent = html_entity_decode($faqContent, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            
            // Remove PageBuilder wrapper divs
            $faqContent = preg_replace('/<div[^>]*data-content-type="html"[^>]*>(.*?)<\/div>/s', '$1', $faqContent);
            
            // Remove other wrapper divs that might contain the content
            $faqContent = preg_replace('/<div[^>]*class="[^"]*faq[^"]*"[^>]*>(.*?)<\/div>/s', '$1', $faqContent);
            
            // Don't normalize whitespace yet - we need to preserve structure for parsing
            $faqContent = trim($faqContent);

            if (empty($faqContent)) {
                return $faqItems;
            }
            
            // Split content into FAQ items by looking for question patterns
            // Split by patterns that indicate start of new FAQ item
            $sections = preg_split('/(?=<title[^>]*><strong|<strong[^>]*>|<h[2-6][^>]*>)/i', $faqContent);

            // Process each section individually
            foreach ($sections as $section) {
                $section = trim($section);
                if (empty($section)) {
                    continue;
                }
                
                $question = '';
                $answer = '';
                
                // Pattern 1: <title><strong>Question</strong></title><p>Answer</p> (with any whitespace/newlines)
                if (preg_match('/<title[^>]*><strong[^>]*>(.*?)<\/strong><\/title>\s*<p[^>]*>(.*?)<\/p>/s', $section, $match)) {
                    $question = trim(strip_tags($match[1]));
                    $answer = trim(strip_tags($match[2]));
                }
                // Pattern 2: <strong>Question</strong> followed by <p>Answer</p> (with any whitespace/newlines between)
                elseif (preg_match('/<strong[^>]*>(.*?)<\/strong>\s*<p[^>]*>(.*?)<\/p>/s', $section, $match)) {
                    $question = trim(strip_tags($match[1]));
                    $answer = trim(strip_tags($match[2]));
                }
                // Pattern 3: <h2>Question</h2> followed by <p>Answer</p>
                elseif (preg_match('/<h[2-6][^>]*>(.*?)<\/h[2-6]>\s*<p[^>]*>(.*?)<\/p>/s', $section, $match)) {
                    $question = trim(strip_tags($match[1]));
                    $answer = trim(strip_tags($match[2]));
                }
                
                // Clean up answer - normalize whitespace
                if (!empty($answer)) {
                    $answer = preg_replace('/\s+/', ' ', $answer);
                    $answer = trim($answer);
                }
                
                if (!empty($question) && !empty($answer)) {
                    $faqItems[] = [
                        'question' => $question,
                        'answer' => $answer
                    ];
                }
            }
            
            // If sections approach didn't work, try direct pattern matching on full content
            if (empty($faqItems)) {
                // Pattern 1: <title><strong>Question</strong></title><p>Answer</p>
                preg_match_all('/<title[^>]*><strong[^>]*>(.*?)<\/strong><\/title>\s*<p[^>]*>(.*?)<\/p>/s', $faqContent, $matches0, PREG_SET_ORDER);
                
                // Pattern 2: <strong>Question</strong><p>Answer</p>
                preg_match_all('/<strong[^>]*>(.*?)<\/strong>\s*<p[^>]*>(.*?)<\/p>/s', $faqContent, $matches1, PREG_SET_ORDER);
                
                // Combine matches
                $allMatches = array_merge($matches0, $matches1);
                
                foreach ($allMatches as $match) {
                    if (!isset($match[1]) || !isset($match[2])) {
                        continue;
                    }

                    $question = trim(strip_tags($match[1]));
                    $answer = trim(strip_tags($match[2]));
                    
                    if (!empty($question) && !empty($answer)) {
                        $faqItems[] = [
                            'question' => $question,
                            'answer' => $answer
                        ];
                    }
                }
            }
            
            // If no matches found, try to split by common separators
            if (empty($faqItems)) {
                // Try splitting by <hr> or multiple <br> tags
                $sections = preg_split('/<hr[^>]*>|<br\s*\/?>\s*<br\s*\/?>/i', $faqContent);
                
                foreach ($sections as $section) {
                    $section = trim(strip_tags($section, '<strong><b><h1><h2><h3><h4><h5><h6><p>'));
                    
                    // Try to extract question and answer from section
                    if (preg_match('/(?:<strong>|<b>|<h[1-6]>)(.*?)(?:<\/strong>|<\/b>|<\/h[1-6]>)\s*(.*)/s', $section, $sectionMatch)) {
                        $question = trim(strip_tags($sectionMatch[1]));
                        $answer = trim(strip_tags($sectionMatch[2]));
                        
                        if (!empty($question) && !empty($answer)) {
                            $faqItems[] = [
                                'question' => $question,
                                'answer' => $answer
                            ];
                        }
                    }
                }
            }
        } catch (\Throwable $e) {
            // Return empty array on error
        }

        return $faqItems;
    }

    /**
     * Get BreadcrumbList schema for homepage
     * Creates a simple breadcrumb with just the homepage
     *
     * @return array|null
     */
    protected function getHomepageBreadcrumbSchema()
    {
        try {
            $baseUrl = $this->storeManager->getStore()->getBaseUrl();
            $storeName = $this->storeManager->getStore()->getName();
            
            $schema = [
                '@context' => 'https://schema.org',
                '@type' => 'BreadcrumbList',
                'itemListElement' => [
                    [
                        '@type' => 'ListItem',
                        'position' => 1,
                        'name' => $storeName ?: 'Home',
                        'item' => $baseUrl
                    ]
                ]
            ];
            
            return $schema;
        } catch (\Throwable $e) {
            return null;
        }
    }
}

