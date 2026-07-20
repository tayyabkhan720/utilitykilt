<?php
namespace Mollie\Payment\Controller\Adminhtml\Action\SendSecondChanceEmail;

/**
 * Interceptor class for @see \Mollie\Payment\Controller\Adminhtml\Action\SendSecondChanceEmail
 */
class Interceptor extends \Mollie\Payment\Controller\Adminhtml\Action\SendSecondChanceEmail implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Sales\Api\OrderRepositoryInterface $orderRepository, \Mollie\Payment\Service\Order\SecondChanceEmail $secondChanceEmail, \Mollie\Payment\Api\SentPaymentReminderRepositoryInterface $sentPaymentReminderRepository, \Mollie\Payment\Api\Data\SentPaymentReminderInterfaceFactory $sentPaymentReminderFactory)
    {
        $this->___init();
        parent::__construct($context, $orderRepository, $secondChanceEmail, $sentPaymentReminderRepository, $sentPaymentReminderFactory);
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
