<?php
namespace Mollie\Payment\Controller\Adminhtml\Action\MarkAsPaid;

/**
 * Interceptor class for @see \Mollie\Payment\Controller\Adminhtml\Action\MarkAsPaid
 */
class Interceptor extends \Mollie\Payment\Controller\Adminhtml\Action\MarkAsPaid implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Sales\Api\OrderRepositoryInterface $orderRepository, \Mollie\Payment\Service\Order\Reorder $reorder, \Magento\Backend\Model\Session\Quote $session)
    {
        $this->___init();
        parent::__construct($context, $orderRepository, $reorder, $session);
    }

    /**
     * {@inheritdoc}
     */
    public function execute(): \Magento\Framework\Controller\Result\Redirect
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
