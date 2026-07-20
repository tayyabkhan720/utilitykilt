<?php
namespace Mollie\Payment\Controller\Adminhtml\Reminder\DeletePendingMassAction;

/**
 * Interceptor class for @see \Mollie\Payment\Controller\Adminhtml\Reminder\DeletePendingMassAction
 */
class Interceptor extends \Mollie\Payment\Controller\Adminhtml\Reminder\DeletePendingMassAction implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Mollie\Payment\Api\PendingPaymentReminderRepositoryInterface $pendingPaymentReminderRepository, \Magento\Ui\Component\MassAction\Filter $filter, \Mollie\Payment\Model\ResourceModel\PendingPaymentReminder\CollectionFactory $collectionFactory)
    {
        $this->___init();
        parent::__construct($context, $pendingPaymentReminderRepository, $filter, $collectionFactory);
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
