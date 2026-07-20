<?php
/**
 * Copyright © Ops. All rights reserved.
 */
namespace Ops\CategoryFaq\Plugin;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Api\Data\CategoryInterface;
use Magento\Framework\App\RequestInterface;

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
     * @param RequestInterface $request
     */
    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
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
        
        // Ensure FAQ attributes are set from request data
        if (isset($data['enable_faq'])) {
            $category->setData('enable_faq', $data['enable_faq']);
        }
        if (isset($data['category_faq'])) {
            $category->setData('category_faq', $data['category_faq']);
        }

        return [$category, $saveOptions];
    }
}

