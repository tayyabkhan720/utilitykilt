<?php
namespace StripeIntegration\Payments\Controller\Adminhtml\Order\RejectReview;

/**
 * Interceptor class for @see \StripeIntegration\Payments\Controller\Adminhtml\Order\RejectReview
 */
class Interceptor extends \StripeIntegration\Payments\Controller\Adminhtml\Order\RejectReview implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Sales\Api\OrderRepositoryInterface $orderRepository, \StripeIntegration\Payments\Helper\Url $urlHelper, \StripeIntegration\Payments\Helper\Creditmemo $creditmemoHelper, \Magento\Backend\Model\Auth\Session $adminSession, \StripeIntegration\Payments\Model\Stripe\PaymentIntentFactory $stripePaymentIntentFactory, \Magento\Framework\App\CacheInterface $cache, \StripeIntegration\Payments\Helper\Order $orderHelper)
    {
        $this->___init();
        parent::__construct($context, $orderRepository, $urlHelper, $creditmemoHelper, $adminSession, $stripePaymentIntentFactory, $cache, $orderHelper);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
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
