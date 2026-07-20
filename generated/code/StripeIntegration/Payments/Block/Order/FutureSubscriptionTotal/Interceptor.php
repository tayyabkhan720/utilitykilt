<?php
namespace StripeIntegration\Payments\Block\Order\FutureSubscriptionTotal;

/**
 * Interceptor class for @see \StripeIntegration\Payments\Block\Order\FutureSubscriptionTotal
 */
class Interceptor extends \StripeIntegration\Payments\Block\Order\FutureSubscriptionTotal implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\StripeIntegration\Payments\Model\ResourceModel\Subscription\Collection $subscriptionCollection, \StripeIntegration\Payments\Helper\Currency $currencyHelper, \Magento\Framework\View\Element\Template\Context $context, \Magento\Framework\Registry $registry, array $data = [])
    {
        $this->___init();
        parent::__construct($subscriptionCollection, $currencyHelper, $context, $registry, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getOrder');
        return $pluginInfo ? $this->___callPlugins('getOrder', func_get_args(), $pluginInfo) : parent::getOrder();
    }
}
