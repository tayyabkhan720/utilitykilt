<?php
namespace Magento\Sales\Model\Order\Email\Sender\InvoiceSender;

/**
 * Interceptor class for @see \Magento\Sales\Model\Order\Email\Sender\InvoiceSender
 */
class Interceptor extends \Magento\Sales\Model\Order\Email\Sender\InvoiceSender implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Sales\Model\Order\Email\Container\Template $templateContainer, \Magento\Sales\Model\Order\Email\Container\InvoiceIdentity $identityContainer, \Magento\Sales\Model\Order\Email\SenderBuilderFactory $senderBuilderFactory, \Psr\Log\LoggerInterface $logger, \Magento\Sales\Model\Order\Address\Renderer $addressRenderer, \Magento\Payment\Helper\Data $paymentHelper, \Magento\Sales\Model\ResourceModel\Order\Invoice $invoiceResource, \Magento\Framework\App\Config\ScopeConfigInterface $globalConfig, \Magento\Framework\Event\ManagerInterface $eventManager, ?\Magento\Store\Model\App\Emulation $appEmulation = null)
    {
        $this->___init();
        parent::__construct($templateContainer, $identityContainer, $senderBuilderFactory, $logger, $addressRenderer, $paymentHelper, $invoiceResource, $globalConfig, $eventManager, $appEmulation);
    }

    /**
     * {@inheritdoc}
     */
    public function send(\Magento\Sales\Model\Order\Invoice $invoice, $forceSyncMode = false)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'send');
        return $pluginInfo ? $this->___callPlugins('send', func_get_args(), $pluginInfo) : parent::send($invoice, $forceSyncMode);
    }
}
