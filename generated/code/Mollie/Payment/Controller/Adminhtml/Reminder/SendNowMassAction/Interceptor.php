<?php
namespace Mollie\Payment\Controller\Adminhtml\Reminder\SendNowMassAction;

/**
 * Interceptor class for @see \Mollie\Payment\Controller\Adminhtml\Reminder\SendNowMassAction
 */
class Interceptor extends \Mollie\Payment\Controller\Adminhtml\Reminder\SendNowMassAction implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Mollie\Payment\Service\Order\PaymentReminder $paymentReminder, \Magento\Ui\Component\MassAction\Filter $filter, \Mollie\Payment\Model\ResourceModel\PendingPaymentReminder\CollectionFactory $collectionFactory)
    {
        $this->___init();
        parent::__construct($context, $paymentReminder, $filter, $collectionFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function execute(): \Magento\Framework\App\ResponseInterface
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        return $pluginInfo ? $this->___callPlugins('execute', func_get_args(), $pluginInfo) : parent::execute();
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(\Magento\Framework\App\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'dispatch');
        return $pluginInfo ? $this->___callPlugins('dispatch', func_get_args(), $pluginInfo) : parent::dispatch($request);
    }
}
