<?php
namespace TJV\PromoShipping\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Catalog\Model\ProductRepository;

class ApplyBuyOneGetShippingFreeObserver implements ObserverInterface
{
    protected $promoHelper;

    public function __construct(
        ProductRepository $productRepository,
        \TJV\PromoShipping\Helper\PromoHelper $promoHelper
    ) {
        $this->promoHelper = $promoHelper;
    }

    public function execute(Observer $observer)
    {
        $quote = $observer->getEvent()->getQuote();
        if (!$quote || $quote->isVirtual() || !$this->promoHelper->isEnabled()) {
            return;
        }

        $previousPromoItemIds = (array)$quote->getData('free_shipping_promo_item_ids');
        if ($previousPromoItemIds) {
            foreach ($quote->getAllVisibleItems() as $item) {
                if (in_array((int)$item->getItemId(), $previousPromoItemIds, true)) {
                    $item->setFreeShipping(false);
                    $item->setFreeShippingMethod(null);
                }
            }
        }
        $quote->unsetData('apply_free_shipping_promo');
        $quote->unsetData('free_shipping_promo_item_ids');
        $quote->getShippingAddress()->setCollectShippingRates(true);

        $triggerProducts = $this->promoHelper->getTriggerProductIds();
        $freeShippingProducts = $this->promoHelper->getFreeShippingProductIds();
        if (!$triggerProducts || !$freeShippingProducts) {
            return;
        }

        $triggerFound = false;
        foreach ($quote->getAllVisibleItems() as $item) {
            if ($this->promoHelper->matchesProduct($item, $triggerProducts)) {
                $triggerFound = true;
                break;
            }
        }

        if (!$triggerFound) {
            return;
        }

        $freeShippingItemIds = [];
        foreach ($quote->getAllVisibleItems() as $item) {
            if (!$this->promoHelper->matchesProduct($item, $freeShippingProducts)) {
                continue;
            }

            $item->setFreeShipping(true);
            $item->setFreeShippingMethod(null);
            $freeShippingItemIds[] = (int)$item->getItemId();
        }

        if ($freeShippingItemIds) {
            $quote->setData('apply_free_shipping_promo', true);
            $quote->setData('free_shipping_promo_item_ids', $freeShippingItemIds);
            $quote->getShippingAddress()->setCollectShippingRates(true);
        }
    }

}