<?php
namespace Mollie\Payment\Controller\Express\Redirect;

/**
 * Interceptor class for @see \Mollie\Payment\Controller\Express\Redirect
 */
class Interceptor extends \Mollie\Payment\Controller\Express\Redirect implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\RequestInterface $request, \Magento\Sales\Api\OrderRepositoryInterface $orderRepository, \Mollie\Payment\Api\PaymentTokenRepositoryInterface $paymentTokenRepository, \Mollie\Payment\Service\Mollie\Order\SuccessPageRedirect $successPageRedirect)
    {
        $this->___init();
        parent::__construct($request, $orderRepository, $paymentTokenRepository, $successPageRedirect);
    }

    /**
     * {@inheritdoc}
     */
    public function execute(): \Magento\Framework\App\ResponseInterface
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        return $pluginInfo ? $this->___callPlugins('execute', func_get_args(), $pluginInfo) : parent::execute();
    }
}
