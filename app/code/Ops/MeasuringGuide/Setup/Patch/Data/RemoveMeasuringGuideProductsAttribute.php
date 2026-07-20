<?php
/**
 * Copyright © Ops. All rights reserved.
 */
namespace Ops\MeasuringGuide\Setup\Patch\Data;

use Magento\Catalog\Model\Category;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\Patch\DataPatchInterface;

/**
 * Remove Measuring Guide Products Attribute
 * Products are now dynamically pulled from "Products in Category"
 */
class RemoveMeasuringGuideProductsAttribute implements DataPatchInterface
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

        // Check if attribute exists and remove it
        // Products are now dynamically pulled from "Products in Category" section
        $attributeId = $eavSetup->getAttributeId(Category::ENTITY, 'measuring_guide_products');
        if ($attributeId) {
            try {
                $eavSetup->removeAttribute(Category::ENTITY, 'measuring_guide_products');
            } catch (\Exception $e) {
                // Attribute might not exist or already removed, continue
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [
            AddMeasuringGuideAttributes::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}

