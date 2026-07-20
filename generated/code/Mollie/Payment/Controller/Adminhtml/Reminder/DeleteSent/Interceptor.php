<?php
namespace Mollie\Payment\Controller\Adminhtml\Reminder\DeleteSent;

/**
 * Interceptor class for @see \Mollie\Payment\Controller\Adminhtml\Reminder\DeleteSent
 */
class Interceptor extends \Mollie\Payment\Controller\Adminhtml\Reminder\DeleteSent implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Mollie\Payment\Api\SentPaymentReminderRepositoryInterface $sentPaymentReminderRepository)
    {
        $this->___init();
        parent::__construct($context, $sentPaymentReminderRepository);
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
