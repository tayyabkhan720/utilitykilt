<?php
namespace Mollie\Payment\Controller\Checkout\Redirect;

/**
 * Interceptor class for @see \Mollie\Payment\Controller\Checkout\Redirect
 */
class Interceptor extends \Mollie\Payment\Controller\Checkout\Redirect implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Checkout\Model\Session $checkoutSession, \Magento\Payment\Helper\Data $paymentHelper, \Magento\Sales\Api\OrderManagementInterface $orderManagement, \Mollie\Payment\Config $config, \Mollie\Payment\Api\PaymentTokenRepositoryInterface $paymentTokenRepository, \Magento\Sales\Api\OrderRepositoryInterface $orderRepository, \Mollie\Payment\Service\Mollie\Order\RedirectUrl $redirectUrl, \Mollie\Payment\Service\Mollie\FormatExceptionMessages $formatExceptionMessages, \Mollie\Payment\Service\OrderLockService $orderLockService)
    {
        $this->___init();
        parent::__construct($context, $checkoutSession, $paymentHelper, $orderManagement, $config, $paymentTokenRepository, $orderRepository, $redirectUrl, $formatExceptionMessages, $orderLockService);
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
