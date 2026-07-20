<?php
/**
 * Copyright © Ops. All rights reserved.
 */
namespace Ops\CategoryFaq\Plugin;

use Magento\Catalog\Controller\Adminhtml\Category\Save;
use Magento\Framework\App\RequestInterface;
use Psr\Log\LoggerInterface;

/**
 * Plugin to ensure FAQ attributes are saved from controller
 */
class CategorySaveControllerPlugin
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
     * Ensure FAQ attributes are included in the request before save
     *
     * @param Save $subject
     * @return array
     */
    public function beforeExecute(Save $subject)
    {
        $data = $this->request->getPostValue();
        
        // Log request data for debugging
        if (!empty($data)) {
            $this->logger->debug('Category Save Controller - Request Data', [
                'enable_faq' => $data['enable_faq'] ?? 'not set',
                'category_faq' => isset($data['category_faq']) ? substr($data['category_faq'], 0, 100) : 'not set',
                'all_keys' => array_keys($data)
            ]);
        }
        
        // Ensure FAQ fields are in the request if they exist
        if (isset($data['enable_faq'])) {
            $this->request->setPostValue('enable_faq', $data['enable_faq']);
        }
        if (isset($data['category_faq'])) {
            $this->request->setPostValue('category_faq', $data['category_faq']);
        }

        return [];
    }
}



