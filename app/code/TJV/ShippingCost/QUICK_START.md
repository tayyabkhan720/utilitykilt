# Category Shipping Cost - Quick Start Guide

## What This Does
Creates a shipping cost attribute at the **category level** that automatically adds to cart totals when products from that category are added.

**Example**: 
- Electronics category has `shipping_cost = 5.00`
- Clothing category has `shipping_cost = 2.50`
- Add 1 electronics product + 1 clothing product = automatically add $7.50 to shipping

---

## Complete File Structure

```
app/code/TJV/ShippingCost/
│
├── Setup/Patch/Data/
│   └── AddCategoryShippingCostAttribute.php
│
├── Model/Total/Quote/
│   └── Carrier/Category.php
│
├── etc/
│   ├── module.xml
│   ├── config.xml
│   ├── di.xml
│   └── schema.graphqls (optional for GraphQL)
│
├── Api/
│   └── ShippingCostInterface.php (optional)
│
├── Model/
│   └── ShippingCost.php (optional)
│
├── registration.php
└── composer.json (optional)
```

---

## 5-Minute Setup

### 1. Create Module Directory
```bash
mkdir -p app/code/TJV/ShippingCost/Setup/Patch/Data
mkdir -p app/code/TJV/ShippingCost/Observer
mkdir -p app/code/TJV/ShippingCost/etc
```

### 2. Copy These Files

**File 1**: `app/code/TJV/ShippingCost/registration.php`
```php
<?php
\Magento\Framework\Component\ComponentRegistrar::register(
    \Magento\Framework\Component\ComponentRegistrar::MODULE,
    'TJV_ShippingCost',
    __DIR__
);
```

**File 2**: `app/code/TJV/ShippingCost/etc/module.xml`
```xml
<?xml version="1.0"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:Module/etc/module.xsd">
    <module name="TJV_ShippingCost" setup_version="1.0.0">
        <sequence>
            <module name="Magento_Catalog"/>
            <module name="Magento_Quote"/>
            <module name="Magento_Sales"/>
        </sequence>
    </module>
</config>
```

**File 3**: `app/code/TJV/ShippingCost/etc/config.xml`
```xml
<?xml version="1.0"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:noNamespaceSchemaLocation="urn:magento:module:Magento_Sales:etc/sales.xsd">
    <section name="quote">
        <group name="totals">
            <carriers>
                <tjv_category>
                    <active>1</active>
                    <model>TJV\ShippingCost\Model\Carrier\Category</model>
                    <name>Shipping by Category</name>
                    <title>Category Shipping</title>
                </tjv_category>
            </carriers>
        </group>
    </section>
</config>
```

**File 4**: `app/code/TJV/ShippingCost/Setup/Patch/Data/AddCategoryShippingCostAttribute.php`
```php
<?php
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
```

**File 5**: `app/code/TJV/ShippingCost/Model/Carrier/Category.php`
```php
<?php
namespace TJV\ShippingCost\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Catalog\Model\CategoryRepository;

class Category extends \Magento\Shipping\Model\Carrier\AbstractCarrier
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function execute(Observer $observer)
    {
        $quote = $observer->getEvent()->getQuote();
        
        if (!$quote || $quote->isVirtual()) {
            return;
        }

        $totalShippingCost = 0;
        $shippingCostsByCategory = [];

        foreach ($quote->getAllVisibleItems() as $item) {
            $product = $item->getProduct();
            $categories = $product->getCategoryIds();

            foreach ($categories as $categoryId) {
                if (!isset($shippingCostsByCategory[$categoryId])) {
                    try {
                        $category = $this->categoryRepository->get($categoryId);
                        $shippingCost = $category->getData('shipping_cost');
                        
                        if ($shippingCost) {
                            $shippingCostsByCategory[$categoryId] = (float)$shippingCost;
                        }
                    } catch (\Exception $e) {
                        // Category not found, skip
                    }
                }
            }
        }

        $totalShippingCost = array_sum($shippingCostsByCategory);

        if ($totalShippingCost > 0) {
            $quote->setShippingAmount($totalShippingCost);
            $quote->setBaseShippingAmount($totalShippingCost);
        }
    }
}
```

### 3. Install & Enable Module
```bash
# Enable module
bin/magento module:enable TJV_ShippingCost

# Run setup upgrade (creates attribute)
bin/magento setup:upgrade

# Clear cache
bin/magento cache:clean
```

### 4. Configure Categories
1. Go to **Catalog > Categories**
2. Edit a category
3. Scroll to **General Information**
4. Enter value in **Shipping Cost** field (e.g., `5.00`)
5. Save category

### 5. Test
1. Add product from the category to cart
2. Go to checkout
3. Verify shipping cost is added automatically ✅

---

## How It Works

```
User adds product to cart
         ↓
Magento collects quote address totals
         ↓
Category shipping total collector runs
         ↓
Loops through cart items → Gets product categories
         ↓
For each category → Gets shipping_cost attribute value
         ↓
Sums all category shipping costs
         ↓
Adds total to quote as shipping amount
         ↓
Checkout displays with shipping cost included
```

---

## Common Customizations

### 1. Change to Higher Order Shipping (don't sum, use max)
```php
// In observer, replace: $totalShippingCost = array_sum($shippingCostsByCategory);
$totalShippingCost = max($shippingCostsByCategory) ?: 0;
```

### 2. Apply as Line Item (not shipping)
```php
// Add custom total instead of shipping
$quote->setData('category_shipping_charge', $totalShippingCost);
```

### 3. Exclude Specific Categories
```php
$excludeCategories = [1, 2, 3]; // Category IDs to exclude
foreach ($categories as $categoryId) {
    if (in_array($categoryId, $excludeCategories)) continue;
    // ... process
}
```

### 4. Limit to Certain Cart Rules
```php
$applyCoupon = $quote->getCouponCode() === 'FREE_SHIPPING';
if ($applyCoupon) $totalShippingCost = 0;
```

---

## Database Check

Verify attribute creation:
```sql
SELECT * FROM catalog_category_entity_decimal 
WHERE attribute_id IN (
    SELECT attribute_id FROM eav_attribute 
    WHERE attribute_code = 'shipping_cost'
);
```

---

## Troubleshooting

| Issue | Solution |
|-------|----------|
| Attribute doesn't appear | Run `bin/magento setup:upgrade` and `bin/magento cache:clean` |
| Shipping not applying | Check product has category with shipping_cost value |
| Value resets on save | Ensure attribute has proper scope (SCOPE_WEBSITE) |
| Works in admin orders only | Observer might need plugin approach instead |

---

Enjoy! 🚀
