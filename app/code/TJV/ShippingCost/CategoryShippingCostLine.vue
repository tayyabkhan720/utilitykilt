<!--
File: app/design/frontend/Hyvä/default/Magento_Checkout/web/js/view/summary/category-shipping-cost.js

Hyvä Checkout component to display category-based shipping costs
-->
<template>
  <div v-if="categoryShippingCost > 0" class="category-shipping-cost">
    <strong class="label">
      {{ translate('Category Shipping Cost') }}
    </strong>
    <span class="price">
      {{ formatPrice(categoryShippingCost) }}
    </span>
  </div>
</template>

<script>
export default {
  name: 'CategoryShippingCostSummary',
  props: {
    quote: {
      type: Object,
      required: true
    }
  },
  computed: {
    categoryShippingCost() {
      const shippingCost = this.quote?.extension_attributes?.category_shipping_cost || 0;
      return parseFloat(shippingCost) || 0;
    }
  },
  methods: {
    formatPrice(price) {
      return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: this.quote?.quote_currency_code || 'USD'
      }).format(price);
    },
    translate(text) {
      // Use Hyvä's translation system
      return window.hyva?.i18n?.(text) || text;
    }
  }
};
</script>

<style scoped>
.category-shipping-cost {
  display: flex;
  justify-content: space-between;
  padding: 8px 0;
  border-top: 1px solid #e0e0e0;
  margin-top: 8px;
}

.category-shipping-cost .label {
  font-weight: 600;
  color: #333;
}

.category-shipping-cost .price {
  color: #e74c3c;
  font-weight: 600;
}
</style>
