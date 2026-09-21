<?php

namespace TJV\ShippingCost\Setup\Patch\Data;

use Magento\Catalog\Model\Category;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class AddShippingCostToCategoryAttributeSet implements DataPatchInterface
{
    private ModuleDataSetupInterface $moduleDataSetup;
    private CategorySetupFactory $categorySetupFactory;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CategorySetupFactory $categorySetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->categorySetupFactory = $categorySetupFactory;
    }

    public function apply()
    {
        $this->moduleDataSetup->startSetup();

        $categorySetup = $this->categorySetupFactory->create([
            'setup' => $this->moduleDataSetup
        ]);
        $attributeSetId = $categorySetup->getDefaultAttributeSetId(Category::ENTITY);

        if ($categorySetup->getAttributeId(Category::ENTITY, 'shipping_cost')) {
            $categorySetup->addAttributeToSet(
                Category::ENTITY,
                $attributeSetId,
                'General Information',
                'shipping_cost'
            );
        }

        $this->moduleDataSetup->endSetup();
    }

    public static function getDependencies()
    {
        return [AddCategoryShippingCostAttribute::class];
    }

    public function getAliases()
    {
        return [];
    }
}
