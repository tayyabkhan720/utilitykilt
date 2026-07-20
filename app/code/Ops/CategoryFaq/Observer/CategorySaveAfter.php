<?php
/**
 * Copyright © Ops. All rights reserved.
 */
namespace Ops\CategoryFaq\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\ResourceModel\Category as CategoryResource;
use Magento\Eav\Api\AttributeRepositoryInterface;
use Psr\Log\LoggerInterface;

/**
 * Observer to save FAQ attributes directly by category ID
 */
class CategorySaveAfter implements ObserverInterface
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
     * @var CategoryResource
     */
    protected $categoryResource;

    /**
     * @var AttributeRepositoryInterface
     */
    protected $attributeRepository;

    /**
     * @param RequestInterface $request
     * @param LoggerInterface $logger
     * @param CategoryResource $categoryResource
     * @param AttributeRepositoryInterface $attributeRepository
     */
    public function __construct(
        RequestInterface $request,
        LoggerInterface $logger,
        CategoryResource $categoryResource,
        AttributeRepositoryInterface $attributeRepository
    ) {
        $this->request = $request;
        $this->logger = $logger;
        $this->categoryResource = $categoryResource;
        $this->attributeRepository = $attributeRepository;
    }

    /**
     * Execute observer - Save FAQ attributes directly
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $category = $observer->getEvent()->getCategory();
        $categoryId = $category->getId();
        $data = $this->request->getPostValue();

        if (!$categoryId) {
            return;
        }

        $this->logger->info('Category Save After - Saving FAQ attributes', [
            'category_id' => $categoryId,
            'has_enable_faq' => isset($data['enable_faq']),
            'has_category_faq' => isset($data['category_faq'])
        ]);

        // Save FAQ attributes directly to database using raw SQL
        $connection = $this->categoryResource->getConnection();
        $entityTypeId = $this->categoryResource->getEntityType()->getId();
        $storeId = $category->getStoreId() ?: 0; // Use 0 for default store if not set
        
        $this->logger->info('Attempting direct DB save', [
            'category_id' => $categoryId,
            'store_id' => $storeId,
            'entity_type_id' => $entityTypeId
        ]);
        
        try {
            // Get attribute IDs
            $enableFaqAttrId = $connection->fetchOne(
                $connection->select()
                    ->from($this->categoryResource->getTable('eav_attribute'), 'attribute_id')
                    ->where('attribute_code = ?', 'enable_faq')
                    ->where('entity_type_id = ?', $entityTypeId)
            );
            
            $categoryFaqAttrId = $connection->fetchOne(
                $connection->select()
                    ->from($this->categoryResource->getTable('eav_attribute'), 'attribute_id')
                    ->where('attribute_code = ?', 'category_faq')
                    ->where('entity_type_id = ?', $entityTypeId)
            );
            
            $this->logger->info('Attribute IDs found', [
                'enable_faq_attr_id' => $enableFaqAttrId,
                'category_faq_attr_id' => $categoryFaqAttrId
            ]);
            
            // Save enable_faq
            if (isset($data['enable_faq'])) {
                if (!$enableFaqAttrId) {
                    $this->logger->error('enable_faq attribute not found in database');
                } else {
                    $enableFaq = (int)$data['enable_faq'];
                    $table = $this->categoryResource->getTable('catalog_category_entity_int');
                    
                    // Delete existing values for all stores
                    $connection->delete($table, [
                        'entity_id = ?' => $categoryId,
                        'attribute_id = ?' => $enableFaqAttrId
                    ]);
                    
                    // Insert new value
                    $connection->insert($table, [
                        'attribute_id' => $enableFaqAttrId,
                        'store_id' => $storeId,
                        'entity_id' => $categoryId,
                        'value' => $enableFaq
                    ]);
                    
                    $this->logger->info('enable_faq saved directly to DB', [
                        'category_id' => $categoryId,
                        'value' => $enableFaq,
                        'attribute_id' => $enableFaqAttrId,
                        'store_id' => $storeId
                    ]);
                }
            }
            
            // Save category_faq - save even if empty to allow clearing
            if (isset($data['category_faq'])) {
                if (!$categoryFaqAttrId) {
                    $this->logger->error('category_faq attribute not found in database');
                } else {
                    $categoryFaq = $data['category_faq'];
                    $table = $this->categoryResource->getTable('catalog_category_entity_text');
                    
                    // Delete existing values for all stores
                    $connection->delete($table, [
                        'entity_id = ?' => $categoryId,
                        'attribute_id = ?' => $categoryFaqAttrId
                    ]);
                    
                    // Insert new value (even if empty, to clear it)
                    $connection->insert($table, [
                        'attribute_id' => $categoryFaqAttrId,
                        'store_id' => $storeId,
                        'entity_id' => $categoryId,
                        'value' => $categoryFaq
                    ]);
                    
                    $this->logger->info('category_faq saved directly to DB', [
                        'category_id' => $categoryId,
                        'length' => strlen($categoryFaq),
                        'attribute_id' => $categoryFaqAttrId,
                        'store_id' => $storeId,
                        'is_empty' => empty(trim($categoryFaq))
                    ]);
                }
            }
        } catch (\Exception $e) {
            $this->logger->error('Error saving FAQ attributes directly', [
                'category_id' => $categoryId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}

