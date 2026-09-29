<?php

namespace TJV\PromoShipping\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use TJV\PromoShipping\Helper\PromoHelper;

/**
 * Temporarily applies product-specific free shipping while quote totals are collected.
 */
class ApplyBuyOneGetShippingFreeObserver implements ObserverInterface
{
    /** @var PromoHelper */
    private PromoHelper $promoHelper;

    /**
     * @param PromoHelper $promoHelper
     */
    public function __construct(PromoHelper $promoHelper)
    {
        $this->promoHelper = $promoHelper;
    }

    /**
     * Apply promo free shipping during totals collection and restore item state afterward.
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        $quote = $observer->getEvent()->getQuote();
        if (!$quote) {
            return;
        }

        $items = $quote->getAllVisibleItems();
        if ($observer->getEvent()->getName() === 'sales_quote_collect_totals_after') {
            $this->restorePromotionalFreeShipping($items);
            return;
        }

        $this->restorePromotionalFreeShipping($items);
        $storeId = (int)$quote->getStoreId();
        if ($quote->isVirtual() || !$this->promoHelper->isEnabled($storeId)) {
            return;
        }

        $triggerProducts = $this->promoHelper->getTriggerProductIds($storeId);
        $freeShippingProducts = $this->promoHelper->getFreeShippingProductIds($storeId);
        if (!$triggerProducts || !$freeShippingProducts) {
            return;
        }

        $triggerFound = false;
        foreach ($items as $item) {
            if ($this->promoHelper->matchesProduct($item, $triggerProducts)) {
                $triggerFound = true;
                break;
            }
        }
        if (!$triggerFound) {
            return;
        }

        $freeShippingApplied = false;
        foreach ($items as $item) {
            if (!$this->promoHelper->matchesProduct($item, $freeShippingProducts)
                || $this->promoHelper->matchesProduct($item, $triggerProducts)
            ) {
                continue;
            }

            $item->setData('tjv_promo_shipping_original_free_shipping', $item->getFreeShipping());
            $item->setData('tjv_promo_shipping_original_free_shipping_method', $item->getFreeShippingMethod());
            $item->setData('tjv_promo_shipping_applied', true);
            $item->setFreeShipping(true);
            $item->setFreeShippingMethod(null);
            $freeShippingApplied = true;
        }

        if ($freeShippingApplied) {
            $quote->getShippingAddress()->setCollectShippingRates(true);
        }
    }

    /**
     * Restore free-shipping values changed temporarily for this promotion.
     *
     * @param array $items
     * @return void
     */
    private function restorePromotionalFreeShipping(array $items): void
    {
        foreach ($items as $item) {
            if (!$item->getData('tjv_promo_shipping_applied')) {
                continue;
            }

            $item->setFreeShipping($item->getData('tjv_promo_shipping_original_free_shipping'));
            $item->setFreeShippingMethod($item->getData('tjv_promo_shipping_original_free_shipping_method'));
            $item->unsetData('tjv_promo_shipping_applied');
            $item->unsetData('tjv_promo_shipping_original_free_shipping');
            $item->unsetData('tjv_promo_shipping_original_free_shipping_method');
        }
    }
}
