<?php
namespace Mollie\Payment\Controller\ApplePay\ShippingMethods;

/**
 * Interceptor class for @see \Mollie\Payment\Controller\ApplePay\ShippingMethods
 */
class Interceptor extends \Mollie\Payment\Controller\ApplePay\ShippingMethods implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Quote\Api\CartRepositoryInterface $cartRepository, \Magento\Quote\Api\ShippingMethodManagementInterface $shippingMethodManagement, \Magento\Checkout\Model\Session $checkoutSession, \Magento\Quote\Api\GuestCartRepositoryInterface $guestCartRepository, \Mollie\Payment\Service\Magento\ChangeShippingMethodForQuote $changeShippingMethodForQuote)
    {
        $this->___init();
        parent::__construct($context, $cartRepository, $shippingMethodManagement, $checkoutSession, $guestCartRepository, $changeShippingMethodForQuote);
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
