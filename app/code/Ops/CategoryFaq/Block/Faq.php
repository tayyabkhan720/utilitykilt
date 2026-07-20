<?php
/**
 * Copyright © Ops. All rights reserved.
 */
namespace Ops\CategoryFaq\Block;

use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\ResourceModel\Category as CategoryResource;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

/**
 * FAQ Block for Category Pages
 */
class Faq extends Template
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
     * @param Context $context
     * @param Registry $registry
     * @param ScopeConfigInterface $scopeConfig
     * @param CategoryResource $categoryResource
     * @param StoreManagerInterface $storeManager
     * @param LoggerInterface $logger
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ScopeConfigInterface $scopeConfig,
        CategoryResource $categoryResource,
        StoreManagerInterface $storeManager,
        LoggerInterface $logger,
        array $data = []
    ) {
        $this->registry = $registry;
        $this->scopeConfig = $scopeConfig;
        $this->categoryResource = $categoryResource;
        $this->storeManager = $storeManager;
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
     * Check if global FAQ is enabled
     *
     * @return bool
     */
    public function isGlobalFaqEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            'categoryfaq/general/enable_all_faq',
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Check if FAQ should be displayed
     *
     * @return bool
     */
    public function shouldDisplayFaq()
    {
        $globalEnabled = $this->isGlobalFaqEnabled();
        
        $category = $this->getCurrentCategory();
        if (!$category || !$category->getId()) {
            $this->logger->info('FAQ Block: No category found');
            return false;
        }

        $categoryId = $category->getId();
        $storeId = $this->storeManager->getStore()->getId();

        // Load attributes directly from resource model using getAttributeRawValue
        // This is the proper way to load EAV attributes that might not be in the category object
        $categoryEnabled = (bool)$this->categoryResource->getAttributeRawValue(
            $categoryId,
            'enable_faq',
            $storeId
        );
        
        $faqContent = $this->categoryResource->getAttributeRawValue(
            $categoryId,
            'category_faq',
            $storeId
        );

        // Ensure $faqContent is a string
        $faqContent = is_string($faqContent) ? $faqContent : '';
        $hasFaqContent = !empty(trim($faqContent));
        $shouldDisplay = $globalEnabled && $categoryEnabled && $hasFaqContent;

        $this->logger->info('FAQ Display Check', [
            'category_id' => $categoryId,
            'store_id' => $storeId,
            'global_enabled' => $globalEnabled,
            'category_enabled' => $categoryEnabled,
            'has_faq_content' => $hasFaqContent,
            'faq_content_length' => strlen($faqContent),
            'should_display' => $shouldDisplay
        ]);

        return $shouldDisplay;
    }

    /**
     * Get FAQ content from category
     *
     * @return string|null
     */
    public function getFaqContent()
    {
        $category = $this->getCurrentCategory();
        if (!$category || !$category->getId()) {
            return null;
        }
        
        $categoryId = $category->getId();
        $storeId = $this->storeManager->getStore()->getId();
        
        // Load attribute directly from resource model
        $faqContent = $this->categoryResource->getAttributeRawValue(
            $categoryId,
            'category_faq',
            $storeId
        );
        
        // Ensure we return a string, not an array
        return is_string($faqContent) ? $faqContent : (is_array($faqContent) ? '' : (string)$faqContent);
    }

    /**
     * Parse FAQ content into array
     *
     * @return array
     */
    public function getFaqItems()
    {
        $faqContent = $this->getFaqContent();
        if (!$faqContent) {
            return [];
        }

        // Decode HTML entities (Page Builder stores content as encoded)
        $faqContent = html_entity_decode($faqContent, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        
        // Remove Page Builder wrapper if present
        $faqContent = preg_replace('/<div[^>]*data-content-type="html"[^>]*>(.*?)<\/div>/s', '$1', $faqContent);
        
        // Clean up any remaining wrapper tags
        $faqContent = trim($faqContent);

        $faqItems = [];
        
        // Match pattern: <strong>Question</strong> followed by <p>Answer</p>
        // Updated regex to handle various formats
        preg_match_all('/<strong>(.*?)<\/strong>\s*(?:<p>)?(.*?)(?:<\/p>)?/s', $faqContent, $matches, PREG_SET_ORDER);

        foreach ($matches as $faq) {
            // Ensure we have the expected array structure
            if (!isset($faq[1]) || !isset($faq[2])) {
                continue;
            }
            
            $question = is_string($faq[1]) ? trim(strip_tags($faq[1])) : '';
            $answer = is_string($faq[2]) ? trim($faq[2]) : '';
            
            // Remove any remaining HTML tags from answer but keep content
            $answer = strip_tags($answer, '<p><br><strong><em><ul><ol><li><a>');

            if (!empty($question) && !empty($answer)) {
                $faqItems[] = [
                    'question' => $question,
                    'answer' => $answer
                ];
            }
        }
        
        // If no matches found with the pattern, try alternative parsing
        if (empty($faqItems)) {
            // Try to split by double line breaks or strong tags
            $parts = preg_split('/<strong>/', $faqContent, -1, PREG_SPLIT_NO_EMPTY);
            foreach ($parts as $part) {
                if (preg_match('/^(.*?)<\/strong>\s*(.*?)$/s', $part, $match)) {
                    if (!isset($match[1]) || !isset($match[2])) {
                        continue;
                    }
                    $question = is_string($match[1]) ? trim(strip_tags($match[1])) : '';
                    $answer = is_string($match[2]) ? trim(strip_tags($match[2], '<p><br><strong><em><ul><ol><li><a>')) : '';
                    if (!empty($question) && !empty($answer)) {
                        $faqItems[] = [
                            'question' => $question,
                            'answer' => $answer
                        ];
                    }
                }
            }
        }

        $this->logger->info('FAQ Items Parsed', [
            'total_items' => count($faqItems),
            'content_length' => strlen($faqContent)
        ]);

        return $faqItems;
    }

    /**
     * Get logger instance
     *
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * Get FAQ JSON-LD schema
     *
     * @return string
     */
    public function getFaqJsonLd()
    {
        $faqItems = $this->getFaqItems();
        if (empty($faqItems)) {
            return '';
        }

        $jsonLd = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => []
        ];

        foreach ($faqItems as $item) {
            $jsonLd['mainEntity'][] = [
                '@type' => 'Question',
                'name' => $item['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => strip_tags($item['answer'])
                ]
            ];
        }

        return json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}

