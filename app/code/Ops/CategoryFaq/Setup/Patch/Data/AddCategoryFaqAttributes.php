<?php
/**
 * Copyright © Ops. All rights reserved.
 */
namespace Ops\CategoryFaq\Setup\Patch\Data;

use Magento\Catalog\Model\Category;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\Patch\DataPatchInterface;

/**
 * Add Category FAQ Attributes
 */
class AddCategoryFaqAttributes implements DataPatchInterface
{
    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create();

        // Check if attributes already exist
        $enableFaqExists = $eavSetup->getAttributeId(Category::ENTITY, 'enable_faq');
        $categoryFaqExists = $eavSetup->getAttributeId(Category::ENTITY, 'category_faq');

        if (!$enableFaqExists) {
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
        }

        if (!$categoryFaqExists) {
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
        }

        // Ensure attributes are added to default attribute set
        $attributeSetId = $eavSetup->getDefaultAttributeSetId(Category::ENTITY);
        
        if (!$enableFaqExists) {
            $eavSetup->addAttributeToSet(
                Category::ENTITY,
                $attributeSetId,
                'Content',
                'enable_faq'
            );
        }
        
        if (!$categoryFaqExists) {
            $eavSetup->addAttributeToSet(
                Category::ENTITY,
                $attributeSetId,
                'Content',
                'category_faq'
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}


