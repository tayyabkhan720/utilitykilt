<?php
namespace StripeIntegration\Payments\Controller\Subscriptions\Reactivate;

/**
 * Interceptor class for @see \StripeIntegration\Payments\Controller\Subscriptions\Reactivate
 */
class Interceptor extends \StripeIntegration\Payments\Controller\Subscriptions\Reactivate implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\StripeIntegration\Payments\Helper\Generic $helper, \StripeIntegration\Payments\Helper\Url $urlHelper, \StripeIntegration\Payments\Model\SubscriptionFactory $subscriptionFactory, \Magento\Customer\Model\Session $session, \Magento\Framework\App\RequestInterface $request, \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator)
    {
        $this->___init();
        parent::__construct($helper, $urlHelper, $subscriptionFactory, $session, $request, $formKeyValidator);
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
