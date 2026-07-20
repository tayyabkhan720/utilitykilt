<?php
namespace StripeIntegration\Payments\Model\Method\Express;

/**
 * Interceptor class for @see \StripeIntegration\Payments\Model\Method\Express
 */
class Interceptor extends \StripeIntegration\Payments\Model\Method\Express implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Event\ManagerInterface $eventManager, \Magento\Payment\Gateway\Config\ValueHandlerPoolInterface $valueHandlerPool, \Magento\Payment\Gateway\Data\PaymentDataObjectFactory $paymentDataObjectFactory, string $code, string $formBlockType, string $infoBlockType, \StripeIntegration\Payments\Model\Config $config, \StripeIntegration\Payments\Model\PaymentElementFactory $paymentElementFactory, \StripeIntegration\Payments\Model\PaymentIntent $paymentIntent, \StripeIntegration\Payments\Model\Stripe\PaymentMethod $stripePaymentMethod, \StripeIntegration\Payments\Model\Checkout\Flow $checkoutFlow, \StripeIntegration\Payments\Model\Stripe\PaymentIntentFactory $stripePaymentIntentFactory, \StripeIntegration\Payments\Model\ResourceModel\PaymentElement $paymentElementResource, \StripeIntegration\Payments\Model\ResourceModel\PaymentElement\Collection $paymentElementCollection, \StripeIntegration\Payments\Model\Cart\Info $cartInfo, \StripeIntegration\Payments\Model\Subscription\Payment $subscriptionPayment, \StripeIntegration\Payments\Helper\Generic $helper, \StripeIntegration\Payments\Helper\Subscriptions $subscriptionsHelper, \StripeIntegration\Payments\Helper\Multishipping $multishippingHelper, \StripeIntegration\Payments\Helper\Refunds $refundsHelper, \StripeIntegration\Payments\Helper\Api $api, \StripeIntegration\Payments\Helper\PaymentIntent $paymentIntentHelper, \StripeIntegration\Payments\Helper\Token $tokenHelper, \StripeIntegration\Payments\Helper\SetupIntent $setupIntentHelper, \StripeIntegration\Payments\Helper\Quote $quoteHelper, \StripeIntegration\Payments\Helper\Order $orderHelper, \StripeIntegration\Payments\Helper\CheckoutSession $checkoutSessionHelper, \StripeIntegration\Payments\Helper\Installments $installmentsHelper, ?\Magento\Payment\Gateway\Command\CommandPoolInterface $commandPool = null, ?\Magento\Payment\Gateway\Validator\ValidatorPoolInterface $validatorPool = null)
    {
        $this->___init();
        parent::__construct($context, $eventManager, $valueHandlerPool, $paymentDataObjectFactory, $code, $formBlockType, $infoBlockType, $config, $paymentElementFactory, $paymentIntent, $stripePaymentMethod, $checkoutFlow, $stripePaymentIntentFactory, $paymentElementResource, $paymentElementCollection, $cartInfo, $subscriptionPayment, $helper, $subscriptionsHelper, $multishippingHelper, $refundsHelper, $api, $paymentIntentHelper, $tokenHelper, $setupIntentHelper, $quoteHelper, $orderHelper, $checkoutSessionHelper, $installmentsHelper, $commandPool, $validatorPool);
    }

    /**
     * {@inheritdoc}
     */
    public function canCapture()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'canCapture');
        return $pluginInfo ? $this->___callPlugins('canCapture', func_get_args(), $pluginInfo) : parent::canCapture();
    }

    /**
     * {@inheritdoc}
     */
    public function canReviewPayment()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'canReviewPayment');
        return $pluginInfo ? $this->___callPlugins('canReviewPayment', func_get_args(), $pluginInfo) : parent::canReviewPayment();
    }

    /**
     * {@inheritdoc}
     */
    public function isActive($storeId = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isActive');
        return $pluginInfo ? $this->___callPlugins('isActive', func_get_args(), $pluginInfo) : parent::isActive($storeId);
    }
}
