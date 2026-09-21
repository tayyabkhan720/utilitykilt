<?php
/**
 * Setup script to create category-level shipping cost attribute
 * Location: app/code/TJV/ShippingCost/Setup/Patch/Data/AddCategoryShippingCostAttribute.php
 */

namespace TJV\ShippingCost\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class AddCategoryShippingCostAttribute implements DataPatchInterface
{
    private $categorySetupFactory;
    private $moduleDataSetup;

    public function __construct(
        CategorySetupFactory $categorySetupFactory,
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->categorySetupFactory = $categorySetupFactory;
        $this->moduleDataSetup = $moduleDataSetup;
    }

    public function apply()
    {
        $this->moduleDataSetup->startSetup();
        
        $categorySetup = $this->categorySetupFactory->create(['setup' => $this->moduleDataSetup]);

        // Create the attribute
        $categorySetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'shipping_cost',
            [
                'type' => 'decimal',
                'label' => 'Shipping Cost',
                'input' => 'text',
                'required' => false,
                'sort_order' => 100,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_WEBSITE,
                'group' => 'General Information',
                'is_used_in_grid' => true,
                'is_visible_in_grid' => false,
                'is_filterable_in_grid' => false,
                'backend' => '',
            ]
        );

        $this->moduleDataSetup->endSetup();
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }
}
