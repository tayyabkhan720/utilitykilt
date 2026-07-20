<?php
namespace StripeIntegration\Payments\Controller\Subscriptions\ChangeShipping;

/**
 * Interceptor class for @see \StripeIntegration\Payments\Controller\Subscriptions\ChangeShipping
 */
class Interceptor extends \StripeIntegration\Payments\Controller\Subscriptions\ChangeShipping implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\StripeIntegration\Payments\Helper\Generic $helper, \StripeIntegration\Payments\Helper\Url $urlHelper, \StripeIntegration\Payments\Helper\Subscriptions $subscriptionsHelper, \StripeIntegration\Payments\Helper\Quote $quoteHelper, \StripeIntegration\Payments\Helper\Product $productHelper, \StripeIntegration\Payments\Helper\Data $dataHelper, \StripeIntegration\Payments\Helper\Order $orderHelper, \StripeIntegration\Payments\Model\SubscriptionProductFactory $subscriptionProductFactory, \StripeIntegration\Payments\Model\Stripe\SubscriptionFactory $stripeSubscriptionFactory, \Magento\Customer\Model\Session $session, \Magento\Framework\App\RequestInterface $request, \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator)
    {
        $this->___init();
        parent::__construct($helper, $urlHelper, $subscriptionsHelper, $quoteHelper, $productHelper, $dataHelper, $orderHelper, $subscriptionProductFactory, $stripeSubscriptionFactory, $session, $request, $formKeyValidator);
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
