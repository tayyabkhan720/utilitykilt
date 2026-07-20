<?php
namespace StripeIntegration\Payments\Controller\Customer\Subscriptions;

/**
 * Interceptor class for @see \StripeIntegration\Payments\Controller\Customer\Subscriptions
 */
class Interceptor extends \StripeIntegration\Payments\Controller\Customer\Subscriptions implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Customer\Model\Session $session, \StripeIntegration\Payments\Helper\Generic $helper, \StripeIntegration\Payments\Helper\Subscriptions $subscriptionsHelper, \StripeIntegration\Payments\Helper\Url $urlHelper, \Magento\Sales\Model\Order $order, \Magento\Framework\App\RequestInterface $request)
    {
        $this->___init();
        parent::__construct($resultPageFactory, $session, $helper, $subscriptionsHelper, $urlHelper, $order, $request);
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
