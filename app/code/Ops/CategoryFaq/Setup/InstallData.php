<?php
/**
 * Copyright © Ops. All rights reserved.
 */
namespace Ops\CategoryFaq\Setup;

use Magento\Catalog\Model\Category;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * Install Data
 */
class InstallData implements InstallDataInterface
{
    /**
     * EAV setup factory
     *
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * Init
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        /**
         * Add attributes to the eav_attribute
         */
        $eavSetup->addAttribute(
            Category::ENTITY,
            'enable_faq',
            [
                'type' => 'int',
                'label' => 'Enable FAQ',
                'input' => 'select',
                'source' => \Magento\Eav\Model\Entity\Attribute\Source\Boolean::class,
                'required' => false,
                'sort_order' => 100,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Content',
                'is_used_in_grid' => false,
                'is_visible_in_grid' => false,
                'is_filterable_in_grid' => false,
                'used_in_product_listing' => true,
                'is_used_for_customer_segment' => false,
                'note' => 'Enable FAQ section for this category'
            ]
        );

        $eavSetup->addAttribute(
            Category::ENTITY,
            'category_faq',
            [
                'type' => 'text',
                'label' => 'FAQ Content',
                'input' => 'textarea',
                'required' => false,
                'sort_order' => 110,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'Content',
                'wysiwyg_enabled' => true,
                'is_html_allowed_on_front' => true,
                'used_in_product_listing' => true,
                'is_used_for_customer_segment' => false,
                'is_wysiwyg_enabled' => true,
                'note' => 'Enter FAQ questions and answers. Format: <strong>Question</strong>Answer</p>'
            ]
        );

        // Ensure attributes are added to default attribute set in Content group
        $attributeSetId = $eavSetup->getDefaultAttributeSetId(Category::ENTITY);
        $eavSetup->addAttributeToSet(
            Category::ENTITY,
            $attributeSetId,
            'Content',
            'enable_faq'
        );
        $eavSetup->addAttributeToSet(
            Category::ENTITY,
            $attributeSetId,
            'Content',
            'category_faq'
        );
    }
}

