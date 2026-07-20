<?php
namespace Mollie\Payment\Controller\Checkout\SecondChance;

/**
 * Interceptor class for @see \Mollie\Payment\Controller\Checkout\SecondChance
 */
class Interceptor extends \Mollie\Payment\Controller\Checkout\SecondChance implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Sales\Api\OrderRepositoryInterface $orderRepository, \Mollie\Payment\Api\PaymentTokenRepositoryInterface $paymentTokenRepository, \Mollie\Payment\Service\Order\Reorder $reorder, \Mollie\Payment\Service\PaymentToken\Generate $generatePaymentToken)
    {
        $this->___init();
        parent::__construct($context, $orderRepository, $paymentTokenRepository, $reorder, $generatePaymentToken);
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
