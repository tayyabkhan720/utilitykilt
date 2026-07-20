<?php
namespace Mollie\Payment\Controller\ApplePay\PlaceOrder;

/**
 * Interceptor class for @see \Mollie\Payment\Controller\ApplePay\PlaceOrder
 */
class Interceptor extends \Mollie\Payment\Controller\ApplePay\PlaceOrder implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Quote\Api\GuestCartRepositoryInterface $guestCartRepository, \Magento\Quote\Api\CartRepositoryInterface $cartRepository, \Magento\Quote\Model\QuoteManagement $quoteManagement, \Magento\Checkout\Model\Session $checkoutSession, \Mollie\Payment\Service\PaymentToken\Generate $paymentToken, \Mollie\Payment\Service\Quote\SetRegionFromApplePayAddress $setRegionFromApplePayAddress, \Magento\Sales\Api\OrderRepositoryInterface $orderRepository, \Mollie\Payment\Config $config, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig)
    {
        $this->___init();
        parent::__construct($context, $guestCartRepository, $cartRepository, $quoteManagement, $checkoutSession, $paymentToken, $setRegionFromApplePayAddress, $orderRepository, $config, $scopeConfig);
    }

    /**
     * {@inheritdoc}
     */
    public function execute(): \Magento\Framework\Controller\Result\Json
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
