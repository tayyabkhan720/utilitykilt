<?php
namespace StripeIntegration\Payments\Controller\Subscriptions\ChangePaymentMethod;

/**
 * Interceptor class for @see \StripeIntegration\Payments\Controller\Subscriptions\ChangePaymentMethod
 */
class Interceptor extends \StripeIntegration\Payments\Controller\Subscriptions\ChangePaymentMethod implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\StripeIntegration\Payments\Helper\Generic $helper, \StripeIntegration\Payments\Helper\Url $urlHelper, \StripeIntegration\Payments\Model\Stripe\SubscriptionFactory $stripeSubscriptionFactory, \Magento\Customer\Model\Session $session, \Magento\Framework\App\RequestInterface $request, \StripeIntegration\Payments\Model\Stripe\SetupIntentFactory $setupIntentFactory)
    {
        $this->___init();
        parent::__construct($helper, $urlHelper, $stripeSubscriptionFactory, $session, $request, $setupIntentFactory);
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
