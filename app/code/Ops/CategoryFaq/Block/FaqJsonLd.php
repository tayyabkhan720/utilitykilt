<?php
/**
 * Copyright © Ops. All rights reserved.
 */
namespace Ops\CategoryFaq\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Catalog\Model\ResourceModel\Category as CategoryResource;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Separate block for FAQ JSON-LD schema
 * Outputs after Amasty's block to prevent conflicts
 */
class FaqJsonLd extends Template
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
     * @param Context $context
     * @param Registry $registry
     * @param ScopeConfigInterface $scopeConfig
     * @param CategoryResource $categoryResource
     * @param StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ScopeConfigInterface $scopeConfig,
        CategoryResource $categoryResource,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->registry = $registry;
        $this->scopeConfig = $scopeConfig;
        $this->categoryResource = $categoryResource;
        $this->storeManager = $storeManager;
    }

    /**
     * Render FAQ JSON-LD schema
     *
     * @return string
     */
    protected function _toHtml()
    {
        try {
            // TEMPORARY DEBUG: Verify block is being called
            $debugOutput = '<!-- FAQ Block is rendering -->';
            
            // Only process on category pages
            $category = $this->registry->registry('current_category');
            if (!$category || !$category->getId()) {
                return $debugOutput . '<!-- FAQ DEBUG: No category -->';
            }

            // Check if FAQ is enabled globally
            $globalEnabled = $this->scopeConfig->isSetFlag(
                'categoryfaq/general/enable_all_faq',
                ScopeInterface::SCOPE_STORE
            );
            if (!$globalEnabled) {
                return $debugOutput . '<!-- FAQ DEBUG: Global FAQ disabled. Check: Stores > Configuration > Category FAQ > Enable All FAQ -->';
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
                return $debugOutput . '<!-- FAQ DEBUG: Category FAQ disabled for category ID: ' . $categoryId . '. Check: Category Edit > FAQ tab > Enable FAQ -->';
            }

            // Get FAQ content
            $faqContent = $this->categoryResource->getAttributeRawValue(
                $categoryId,
                'category_faq',
                $storeId
            );
            if (empty($faqContent) || !is_string($faqContent)) {
                return $debugOutput . '<!-- FAQ DEBUG: No FAQ content for category ID: ' . $categoryId . '. Check: Category Edit > FAQ tab > Category FAQ content -->';
            }

            // Parse FAQ content
            $faqItems = $this->parseFaqContent($faqContent);
            if (empty($faqItems)) {
                return $debugOutput . '<!-- FAQ DEBUG: No FAQ items parsed from content. Content format should be: <strong>Question</strong><p>Answer</p> -->';
            }

            // Build FAQ schema
            $faqSchema = $this->buildFaqSchema($faqItems);
            if (!$faqSchema || !is_array($faqSchema) || empty($faqSchema)) {
                // DEBUG: Uncomment to see why FAQ is not showing
                // return '<!-- FAQ DEBUG: FAQ schema is empty -->';
                return '';
            }

            // Encode JSON
            $json = json_encode($faqSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            if ($json === false || json_last_error() !== JSON_ERROR_NONE) {
                // DEBUG: Uncomment to see why FAQ is not showing
                // return '<!-- FAQ DEBUG: JSON encoding failed -->';
                return '';
            }

            // Return script tag
            return "<script type=\"application/ld+json\">{$json}</script>";
        } catch (\Throwable $e) {
            // Show error in comment for debugging
            return '<!-- FAQ DEBUG: Exception: ' . htmlspecialchars($e->getMessage()) . ' in ' . $e->getFile() . ':' . $e->getLine() . ' -->';
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
     *
     * @param string $faqContent
     * @return array
     */
    protected function parseFaqContent($faqContent)
    {
        $faqItems = [];

        try {
            $faqContent = html_entity_decode($faqContent, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $faqContent = preg_replace('/<div[^>]*data-content-type="html"[^>]*>(.*?)<\/div>/s', '$1', $faqContent);
            $faqContent = trim($faqContent);

            if (empty($faqContent)) {
                return $faqItems;
            }

            preg_match_all('/<strong>(.*?)<\/strong>\s*(?:<p>)?(.*?)(?:<\/p>)?/s', $faqContent, $matches, PREG_SET_ORDER);

            foreach ($matches as $match) {
                if (!isset($match[1]) || !isset($match[2])) {
                    continue;
                }

                $question = trim(strip_tags($match[1]));
                $answer = trim($match[2]);
                $answer = strip_tags($answer, '<p><br><strong><em><ul><ol><li><a>');

                if (!empty($question) && !empty($answer)) {
                    $faqItems[] = [
                        'question' => $question,
                        'answer' => $answer
                    ];
                }
            }
        } catch (\Throwable $e) {
            // Return empty array on error
        }

        return $faqItems;
    }
}
