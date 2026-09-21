# Category Shipping Cost Implementation Guide

## Overview
This guide implements a category-level attribute for shipping costs that automatically applies to cart checkout in Magento 2 with Hyvä theme.

---

## Step 1: Create Category Attribute

### Option A: Via Setup Patch (Recommended)
```
File: app/code/TJV/ShippingCost/Setup/Patch/Data/AddCategoryShippingCostAttribute.php
```
- Run: `bin/magento setup:upgrade`
- Attribute appears in Category admin under "General Information"

### Option B: Via Admin UI
1. Go to **Stores > Attributes > Category**
2. Click **New Attribute**
3. Set:
   - Attribute Code: `shipping_cost`
   - Catalog Input Type: `Decimal`
   - Required: `No`
   - Scope: `Website`
   - Sort Order: `100`

---

## Step 2: Apply Shipping Cost to Cart

### Shipping Method
**File**: `app/code/TJV/ShippingCost/Model/Carrier/Category.php`

The carrier runs during Magento's normal shipping-rate collection:

- Iterates through shippable cart items
- Gets category IDs for each product
- Retrieves each category's `shipping_cost` attribute
- Sums each category once
- Returns one selectable `tjv_category/category` shipping method
- The selected rate is included in shipping and grand totals

**Register in**: `app/code/TJV/ShippingCost/etc/config.xml`

### Approach B: Plugin (Better for Shipping Methods)
If integrating with existing shipping methods:

```php
namespace TJV\ShippingCost\Plugin\Shipping;

use Magento\Shipping\Model\ShippingMethodsCollection;

class AddCategoryShippingMethod
{
    public function afterGetMethods(
        ShippingMethodsCollection $subject,
        $result
    ) {
        // Modify or add shipping methods based on category
        return $result;
    }
}
```

---

## Step 3: Database Behavior

After running `setup:upgrade`:

1. Attribute created in EAV system:
   - Table: `catalog_category_entity_decimal`
   - Attribute ID: Auto-assigned

2. Values stored per website (due to scope setting)

3. Query example:
```sql
SELECT cat.name, cat_attr.value as shipping_cost
FROM catalog_category_entity cat
JOIN catalog_category_entity_decimal cat_attr 
  ON cat.entity_id = cat_attr.entity_id
WHERE cat_attr.attribute_id = (
  SELECT attribute_id FROM eav_attribute 
  WHERE entity_type_id = 3 AND attribute_code = 'shipping_cost'
);
```

---

## Step 4: Extend GraphQL API (for Hyvä)

If using custom GraphQL checkout, extend quote and category types:

**File**: `app/code/TJV/ShippingCost/etc/schema.graphqls`

```graphql
type CategoryInterface {
    shipping_cost: Float
}

type Cart {
    category_shipping_cost: Float
    extension_attributes: JSON
}

type Quote {
    category_shipping_cost: Float
}
```

---

## Step 5: Hyvä Checkout Integration

### Option A: Modify Checkout Totals Summary

**File**: `app/design/frontend/Hyvä/default/Magento_Checkout/web/js/view/summary/category-shipping-cost.js`

```js
define([
    'uiComponent',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/model/totals',
    'mage/translate'
], function (Component, quote, totals, $t) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Magento_Checkout/summary/category-shipping-cost'
        },
        totals: totals.totals,
        quote: quote,
        
        isCategoryShippingVisible: function() {
            return parseFloat(this.getCategoryShippingCost()) > 0;
        },
        
        getCategoryShippingCost: function() {
            return quote.totals()['category_shipping_cost'] || 0;
        },
        
        getFormattedCost: function() {
            return this.getFormattedPrice(this.getCategoryShippingCost());
        }
    });
});
```

### Option B: Custom Cart Item Extension

**File**: `app/code/TJV/ShippingCost/Plugin/Quote/Item/ToOrderItem.php`

```php
namespace TJV\ShippingCost\Plugin\Quote\Item;

class ToOrderItem
{
    public function aroundConvert(
        \Magento\Sales\Model\Convert\Quote\Item $subject,
        \Closure $proceed,
        $item
    ) {
        $orderItem = $proceed($item);
        
        // Add category shipping cost to order item data
        if ($categoryShippingCost = $item->getCategoryShippingCost()) {
            $orderItem->setData('category_shipping_cost', $categoryShippingCost);
        }
        
        return $orderItem;
    }
}
```

---

## Step 6: Testing

### Test Checklist:

1. ✅ Attribute appears in category admin
2. ✅ Can save shipping cost values per category
3. ✅ Add product from category to cart → shipping cost applies
4. ✅ Add product from multiple categories → all costs sum
5. ✅ Remove category product → cost recalculates
6. ✅ Checkout displays total with category shipping included
7. ✅ Order confirmation shows breakdown
8. ✅ Admin order shows category shipping cost line item

### Test via CLI:
```bash
# Verify observer is registered
bin/magento config:show | grep shipping_cost

# Check attribute creation
bin/magento eav:attribute:view catalog_category shipping_cost

# Debug with query
bin/magento dev:query-log:enable
# Then load a category admin page to verify attribute loads
```

---

## Step 7: Configuration & Admin UI

### Add to System Config (Optional)

**File**: `app/code/TJV/ShippingCost/etc/adminhtml/system.xml`

```xml
<?xml version="1.0"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
        xsi:noNamespaceSchemaLocation="urn:magento:module:Magento_Config/etc/system_file.xsd">
    <system>
        <section id="catalog">
            <group id="category_shipping" translate="label" sortOrder="999">
                <label>Category Shipping Settings</label>
                <field id="enable_category_shipping" translate="label" type="select" sortOrder="10">
                    <label>Enable Category Shipping Costs</label>
                    <source_model>Magento\Config\Model\Config\Source\Yesno</source_model>
                </field>
            </group>
        </section>
    </system>
</config>
```

---

## Troubleshooting

### Shipping Cost Not Applying
- [ ] Attribute value actually saved for category
- [ ] Observer firing: Add log in `execute()` method
- [ ] Quote has visible items with this category
- [ ] Check: `SELECT * FROM catalog_category_entity_decimal WHERE attribute_id = X`

### Attribute Not Showing in Category Admin
- [ ] Run: `bin/magento setup:upgrade && bin/magento cache:clean`
- [ ] Check backend settings aren't hiding it
- [ ] Verify attribute group assignment

### Price Not Showing in Checkout
- [ ] Verify GraphQL type extension if using custom checkout
- [ ] Check Hyvä cart totals template includes custom total
- [ ] Browser console for JavaScript errors

---

## Files Summary

```
app/code/TJV/ShippingCost/
├── Setup/Patch/Data/
│   └── AddCategoryShippingCostAttribute.php
├── Observer/
│   └── CategoryShippingCost.php
├── Plugin/
│   └── Quote/Item/ToOrderItem.php (optional)
├── etc/
│   ├── module.xml
│   ├── sales.xml
│   ├── schema.graphqls (optional)
│   └── adminhtml/
│       └── system.xml (optional)
└── registration.php
```

---

## Performance Considerations

1. **Category Loading**: Observer loads categories via repository (cached by Magento)
2. **Quote Recalculation**: Minimal overhead, runs once per totals collection
3. **Database Queries**: 
   - 1 query per unique category in cart
   - Results cached by repository
4. **Optimization Tip**: Cache category shipping costs in session if high traffic

---

## Alternative: Shipping Method

If you prefer custom shipping method instead of direct addition:

Create a shipping method that:
- Reads category shipping costs
- Returns as shipping option
- Allows customer selection

**Advantage**: More flexible, appears in shipping selection  
**Disadvantage**: More complex, requires customer action
