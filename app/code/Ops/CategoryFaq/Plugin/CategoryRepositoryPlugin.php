<?php
/**
 * Copyright © Ops. All rights reserved.
 */
namespace Ops\CategoryFaq\Plugin;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Api\Data\CategoryInterface;
use Magento\Framework\App\RequestInterface;
use Psr\Log\LoggerInterface;

/**
 * Plugin to ensure FAQ attributes are saved
 */
class CategoryRepositoryPlugin
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
     * Ensure FAQ attributes are saved when category is saved
     *
     * @param CategoryRepositoryInterface $subject
     * @param CategoryInterface $category
     * @param bool $saveOptions
     * @return array
     */
    public function beforeSave(
        CategoryRepositoryInterface $subject,
        CategoryInterface $category,
        $saveOptions = false
    ) {
        $data = $this->request->getPostValue();
        
        // Check for FAQ data in request
        $enableFaq = $data['enable_faq'] ?? null;
        $categoryFaq = $data['category_faq'] ?? null;
        
        // Set the attributes if found - this ensures they're in the category object before save
        if ($enableFaq !== null) {
            $category->setData('enable_faq', (int)$enableFaq);
            $this->logger->info('Repository Plugin: Setting enable_faq', [
                'category_id' => $category->getId(),
                'value' => $enableFaq
            ]);
        }
        
        if ($categoryFaq !== null) {
            $category->setData('category_faq', $categoryFaq);
            $this->logger->info('Repository Plugin: Setting category_faq', [
                'category_id' => $category->getId(),
                'length' => strlen($categoryFaq)
            ]);
        }

        return [$category, $saveOptions];
    }
}

