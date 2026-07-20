<?php
/**
 * Copyright © Ops. All rights reserved.
 */
namespace Ops\CategoryFaq\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\RequestInterface;
use Psr\Log\LoggerInterface;

/**
 * Observer to save FAQ attributes
 */
class CategorySaveBefore implements ObserverInterface
{
    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param RequestInterface $request
     * @param LoggerInterface $logger
     */
    public function __construct(
        RequestInterface $request,
        LoggerInterface $logger
    ) {
        $this->request = $request;
        $this->logger = $logger;
    }

    /**
     * Execute observer
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $category = $observer->getEvent()->getCategory();
        $data = $this->request->getPostValue();

        $this->logger->info('Category Save Before Observer - Request Data', [
            'category_id' => $category->getId(),
            'has_enable_faq' => isset($data['enable_faq']),
            'has_category_faq' => isset($data['category_faq']),
            'all_keys' => array_keys($data ?? [])
        ]);

        // Check for FAQ data in various locations
        $enableFaq = null;
        $categoryFaq = null;

        // Direct in post data
        if (isset($data['enable_faq'])) {
            $enableFaq = $data['enable_faq'];
        }
        if (isset($data['category_faq']) && !empty(trim($data['category_faq']))) {
            $categoryFaq = $data['category_faq'];
        }

        // Check in nested structures
        if (isset($data['general']['enable_faq'])) {
            $enableFaq = $data['general']['enable_faq'];
        }
        if (isset($data['general']['category_faq']) && !empty(trim($data['general']['category_faq']))) {
            $categoryFaq = $data['general']['category_faq'];
        }

        if (isset($data['content']['enable_faq'])) {
            $enableFaq = $data['content']['enable_faq'];
        }
        if (isset($data['content']['category_faq']) && !empty(trim($data['content']['category_faq']))) {
            $categoryFaq = $data['content']['category_faq'];
        }

        // Log all category_faq related keys for debugging
        $faqKeys = array_filter(array_keys($data ?? []), function($key) {
            return stripos($key, 'faq') !== false;
        });
        if (!empty($faqKeys)) {
            $this->logger->info('FAQ related keys found', ['keys' => $faqKeys]);
            foreach ($faqKeys as $key) {
                $this->logger->info("FAQ key: $key", ['value' => substr($data[$key] ?? '', 0, 200)]);
            }
        }

        // Set the attributes in beforeSave so they're included in the main save
        // Ensure they're marked as changed so Magento saves them
        if ($enableFaq !== null) {
            $oldValue = $category->getData('enable_faq');
            $category->setData('enable_faq', $enableFaq);
            // Force Magento to recognize this as changed
            if ($oldValue != $enableFaq) {
                $category->setOrigData('enable_faq', $oldValue);
            }
            $this->logger->info('Setting enable_faq in beforeSave', [
                'value' => $enableFaq,
                'old_value' => $oldValue
            ]);
        }
        
        // Set category_faq - accept empty string too (user might be clearing it)
        if (isset($data['category_faq'])) {
            $oldValue = $category->getData('category_faq');
            $category->setData('category_faq', $data['category_faq']);
            // Force Magento to recognize this as changed
            if ($oldValue != $data['category_faq']) {
                $category->setOrigData('category_faq', $oldValue);
            }
            $this->logger->info('Setting category_faq in beforeSave', [
                'value' => substr($data['category_faq'], 0, 100), 
                'length' => strlen($data['category_faq']),
                'is_empty' => empty(trim($data['category_faq'])),
                'old_length' => strlen($oldValue ?? '')
            ]);
        } else {
            $this->logger->warning('category_faq not in request data', [
                'data_keys' => array_keys($data ?? [])
            ]);
        }
        
        // Ensure the category knows these attributes should be saved
        $category->setHasDataChanges(true);
    }
}


