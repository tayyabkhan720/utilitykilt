<?php

namespace StripeIntegration\Payments\Model\Stripe\Event;

use StripeIntegration\Payments\Model\Stripe\StripeObjectTrait;

class RefundUpdated
{
    use StripeObjectTrait;

    private $webhooksHelper;
    private $orderHelper;
    private $convert;
    private $currencyHelper;
    private $creditmemoService;
    private $refundModelFactory;

    public function __construct(
        \Magento\Sales\Model\Service\CreditmemoService $creditmemoService,
        \StripeIntegration\Payments\Model\Stripe\Service\StripeObjectServicePool $stripeObjectServicePool,
        \StripeIntegration\Payments\Helper\Order $orderHelper,
        \StripeIntegration\Payments\Helper\Convert $convert,
        \StripeIntegration\Payments\Helper\Webhooks $webhooksHelper,
        \StripeIntegration\Payments\Helper\Currency $currencyHelper,
        \StripeIntegration\Payments\Model\Stripe\RefundFactory $refundModelFactory
    )
    {
        $stripeObjectService = $stripeObjectServicePool->getStripeObjectService('events');
        $this->setData($stripeObjectService);

        $this->creditmemoService = $creditmemoService;
        $this->orderHelper = $orderHelper;
        $this->convert = $convert;
        $this->webhooksHelper = $webhooksHelper;
        $this->currencyHelper = $currencyHelper;
        $this->refundModelFactory = $refundModelFactory;
    }

    public function process($arrEvent, $object)
    {
        // Use the event object status rather than re-fetching from the API,
        // because the event represents the state at the time it was sent.
        if (empty($object['status']) || $object['status'] != 'succeeded')
            return;

        $refundModel = $this->refundModelFactory->create()->fromRefundId($object['id']);

        $order = $this->webhooksHelper->loadOrderFromEvent($arrEvent);
        $this->webhooksHelper->detectRaceCondition($order->getIncrementId(), ['charge.dispute.closed', 'charge.refunded']);

        $currency = $refundModel->getCurrency();
        $formattedAmount = $this->currencyHelper->formatStripePrice($refundModel->getAmount(), $currency);

        // Clear the creditmemos collection to ensure we get fresh data from the database.
        // The order may have been cached from a prior webhook call that loaded an older set of credit memos.
        $creditmemosCollection = $order->getCreditmemosCollection();
        if ($creditmemosCollection)
        {
            $creditmemosCollection->clear();
        }

        // Check if there's an existing pending (STATE_OPEN) credit memo
        $pendingCreditmemo = $this->getPendingCreditmemo($order, $refundModel->getAmount(), $currency);

        if ($pendingCreditmemo)
        {
            // Finalize the pending credit memo by processing it offline
            $pendingCreditmemo->setOrder($order);
            $this->creditmemoService->refund($pendingCreditmemo, true);
            $comment = __("The pending refund of %1 has been confirmed by Stripe.", $formattedAmount);
            $this->orderHelper->addOrderComment($comment, $order);
            $this->orderHelper->saveOrder($order);
            return;
        }
        else
        {
            $comment = __("A refund of %1 has been processed in Stripe.", $formattedAmount);
            $this->orderHelper->addOrderComment($comment, $order);
            $this->orderHelper->saveOrder($order);
            return;
        }
    }

    private function getPendingCreditmemo($order, $stripeRefundAmount, $currency)
    {
        foreach ($order->getCreditmemosCollection() as $creditmemo)
        {
            if ($creditmemo->getState() == \Magento\Sales\Model\Order\Creditmemo::STATE_OPEN)
            {
                $creditmemoStripeAmount = $this->convert->magentoAmountToStripeAmount($creditmemo->getGrandTotal(), $currency);
                if ($creditmemoStripeAmount == $stripeRefundAmount) {
                    return $creditmemo;
                }
            }
        }
        return null;
    }
}
