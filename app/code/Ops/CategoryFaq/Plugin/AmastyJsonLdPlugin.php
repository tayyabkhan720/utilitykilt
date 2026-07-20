<?php
/**
 * Copyright © Ops. All rights reserved.
 */
namespace Ops\CategoryFaq\Plugin;

use Amasty\SeoRichData\Block\JsonLd;
use Magento\Framework\Registry;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Catalog\Model\ResourceModel\Category as CategoryResource;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Plugin to add FAQ schema to Amasty's JsonLd block
 * Adds FAQ to the data array so it's output in the same loop
 */
class AmastyJsonLdPlugin
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
     * @param Registry $registry
     * @param ScopeConfigInterface $scopeConfig
     * @param CategoryResource $categoryResource
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Registry $registry,
        ScopeConfigInterface $scopeConfig,
        CategoryResource $categoryResource,
        StoreManagerInterface $storeManager
    ) {
        $this->registry = $registry;
        $this->scopeConfig = $scopeConfig;
        $this->categoryResource = $categoryResource;
        $this->storeManager = $storeManager;
    }

    /**
     * Add FAQ schema to Amasty's data array after prepareData
     * This way FAQ will be output in the same loop as other schemas
     *
     * @param JsonLd $subject
     * @param array $data
     * @return array
     */
    public function afterPrepareData(JsonLd $subject, array $data)
    {
        try {
            // Only process on category pages
            $category = $this->registry->registry('current_category');
            if (!$category || !$category->getId()) {
                return $data;
            }

            // Check if FAQ is enabled globally
            $globalEnabled = $this->scopeConfig->isSetFlag(
                'categoryfaq/general/enable_all_faq',
                ScopeInterface::SCOPE_STORE
            );
            if (!$globalEnabled) {
                return $data;
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
                return $data;
            }

            // Get FAQ content
            $faqContent = $this->categoryResource->getAttributeRawValue(
                $categoryId,
                'category_faq',
                $storeId
            );
            if (empty($faqContent) || !is_string($faqContent)) {
                return $data;
            }

            // Parse FAQ content
            $faqItems = $this->parseFaqContent($faqContent);
            if (empty($faqItems)) {
                return $data;
            }

            // Build FAQ schema
            $faqSchema = $this->buildFaqSchema($faqItems);
            if ($faqSchema && is_array($faqSchema) && !empty($faqSchema)) {
                // Add FAQ to data array - it will be output as a separate script tag
                $data['faq'] = $faqSchema;
            }
        } catch (\Throwable $e) {
            // Fail silently - don't break Amasty's output
            // Return original data on any error
        }

        return $data;
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
