<?php

namespace StripeIntegration\Payments\Observer;

use Magento\Payment\Observer\AbstractDataAssignObserver;
use Magento\Framework\Event\Observer;

// sales_model_service_quote_submit_success
// sales_model_service_quote_submit_failure
class AfterQuoteSubmit extends AbstractDataAssignObserver
{
    private $checkoutFlow;
    private $quoteHelper;
    private $orderHelper;

    public function __construct(
        \StripeIntegration\Payments\Model\Checkout\Flow $checkoutFlow,
        \StripeIntegration\Payments\Helper\Quote $quoteHelper,
        \StripeIntegration\Payments\Helper\Order $orderHelper
    )
    {
        $this->checkoutFlow = $checkoutFlow;
        $this->quoteHelper = $quoteHelper;
        $this->orderHelper = $orderHelper;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $quote = $observer->getEvent()->getQuote();

        if ($this->checkoutFlow->isQuoteCorrupted)
        {
            $this->restoreTotals($quote);
        }

        // Release the advisory lock acquired in OrderService::aroundPlace().
        // This observer runs on sales_model_service_quote_submit_success/failure,
        // which fires after SubmitObserver has already sent the order email.
        // Releasing here ensures webhook handlers waiting on the lock will proceed
        // only after the full order placement flow (including email sending) is done.
        if ($quote && $quote->getId())
        {
            $this->orderHelper->releaseOrderPlacementLock($quote->getId());
        }
    }

    private function restoreTotals($quote)
    {
        foreach ($quote->getAllItems() as $item)
        {
            if ($item->getStripeOriginalSubscriptionPrice())
            {
                $item->setCustomPrice($item->getStripeOriginalSubscriptionPrice());
                $item->setOriginalCustomPrice($item->getStripeOriginalSubscriptionPrice());
                $item->getProduct()->setIsSuperMode(true);
                $item->setStripeOriginalSubscriptionPrice(null);
                $item->setStripeBaseOriginalSubscriptionPrice(null);
                $this->checkoutFlow->isQuoteCorrupted = false;
            }
        }
        $this->checkoutFlow->disableZeroInitialPrices();
        $this->quoteHelper->reCollectTotals($quote);
    }
}