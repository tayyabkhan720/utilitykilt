<?php
namespace StripeIntegration\Payments\Controller\Payment\Index;

/**
 * Interceptor class for @see \StripeIntegration\Payments\Controller\Payment\Index
 */
class Interceptor extends \StripeIntegration\Payments\Controller\Payment\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Checkout\Model\Session $checkoutSession, \StripeIntegration\Payments\Helper\Generic $helper, \StripeIntegration\Payments\Helper\Quote $quoteHelper, \StripeIntegration\Payments\Helper\Order $orderHelper, \StripeIntegration\Payments\Helper\PaymentIntent $paymentIntentHelper, \StripeIntegration\Payments\Helper\Multishipping $multishippingHelper, \StripeIntegration\Payments\Helper\Token $tokenHelper, \StripeIntegration\Payments\Model\Config $config, \StripeIntegration\Payments\Model\PaymentElement $paymentElement, \StripeIntegration\Payments\Model\ResourceModel\CheckoutSession\Collection $checkoutSessionCollection, \StripeIntegration\Payments\Model\Stripe\PaymentIntentFactory $stripePaymentIntentFactory, \Magento\Framework\App\RequestInterface $request, \Magento\Framework\Controller\ResultFactory $resultFactory, \Magento\Framework\Message\ManagerInterface $messageManager)
    {
        $this->___init();
        parent::__construct($checkoutSession, $helper, $quoteHelper, $orderHelper, $paymentIntentHelper, $multishippingHelper, $tokenHelper, $config, $paymentElement, $checkoutSessionCollection, $stripePaymentIntentFactory, $request, $resultFactory, $messageManager);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        return $pluginInfo ? $this->___callPlugins('execute', func_get_args(), $pluginInfo) : parent::execute();
    }
}
