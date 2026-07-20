<?php
/**
 * Copyright © Ops. All rights reserved.
 */
namespace Ops\MeasuringGuide\Setup\Patch\Data;

use Magento\Catalog\Model\Category;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\Patch\DataPatchInterface;

/**
 * Add Category Measuring Guide Attributes
 */
class AddMeasuringGuideAttributes implements DataPatchInterface
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
        $enableMeasuringGuideExists = $eavSetup->getAttributeId(Category::ENTITY, 'enable_measuring_guide');
        $measuringGuideContentExists = $eavSetup->getAttributeId(Category::ENTITY, 'measuring_guide_content');

        if (!$enableMeasuringGuideExists) {
            $eavSetup->addAttribute(
                Category::ENTITY,
                'enable_measuring_guide',
                [
                    'type' => 'int',
                    'label' => 'Enable Measuring Guide',
                    'input' => 'select',
                    'source' => \Magento\Eav\Model\Entity\Attribute\Source\Boolean::class,
                    'required' => false,
                    'sort_order' => 200,
                    'global' => ScopedAttributeInterface::SCOPE_STORE,
                    'group' => 'Content',
                    'is_used_in_grid' => false,
                    'is_visible_in_grid' => false,
                    'is_filterable_in_grid' => false,
                    'used_in_product_listing' => true,
                    'is_used_for_customer_segment' => false,
                    'note' => 'Enable Measuring Guide section for this category'
                ]
            );
        }

        if (!$measuringGuideContentExists) {
            $eavSetup->addAttribute(
                Category::ENTITY,
                'measuring_guide_content',
                [
                    'type' => 'text',
                    'label' => 'Measuring Guide Content',
                    'input' => 'textarea',
                    'required' => false,
                    'sort_order' => 210,
                    'global' => ScopedAttributeInterface::SCOPE_STORE,
                    'group' => 'Content',
                    'wysiwyg_enabled' => true,
                    'is_html_allowed_on_front' => true,
                    'used_in_product_listing' => true,
                    'is_used_for_customer_segment' => false,
                    'is_wysiwyg_enabled' => true,
                    'note' => 'Enter measuring guide content. This content can reference FAQ Content format. Products from "Products in Category" section will automatically be displayed with the measuring guide.'
                ]
            );
        }

        // Ensure attributes are added to default attribute set
        $attributeSetId = $eavSetup->getDefaultAttributeSetId(Category::ENTITY);
        
        if (!$enableMeasuringGuideExists) {
            $eavSetup->addAttributeToSet(
                Category::ENTITY,
                $attributeSetId,
                'Content',
                'enable_measuring_guide'
            );
        }
        
        if (!$measuringGuideContentExists) {
            $eavSetup->addAttributeToSet(
                Category::ENTITY,
                $attributeSetId,
                'Content',
                'measuring_guide_content'
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

