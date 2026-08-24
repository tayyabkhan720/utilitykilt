<?php
namespace Utility\CheckoutComments\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;

class CopyCustomerNoteToOrder implements ObserverInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function execute(Observer $observer)
    {
        $quote = $observer->getEvent()->getQuote();
        $order = $observer->getEvent()->getOrder();

        $this->logger->info('CopyCustomerNoteToOrder OBSERVER FIRED', [
            'has_quote' => (bool) $quote,
            'has_order' => (bool) $order,
            'quote_note' => $quote ? $quote->getCustomerNote() : 'NO_QUOTE',
        ]);

        if ($quote && $order && $quote->getCustomerNote()) {
            $order->setCustomerNote($quote->getCustomerNote());
            $order->setCustomerNoteNotify(true);
        }
    }
}
