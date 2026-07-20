<?php
namespace Magento\Paypal\Block\Express\Review\Details;

/**
 * Interceptor class for @see \Magento\Paypal\Block\Express\Review\Details
 */
class Interceptor extends \Magento\Paypal\Block\Express\Review\Details implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Magento\Customer\Model\Session $customerSession, \Magento\Checkout\Model\Session $checkoutSession, \Magento\Sales\Model\ConfigInterface $salesConfig, array $layoutProcessors = [], array $data = [])
    {
        $this->___init();
        parent::__construct($context, $customerSession, $checkoutSession, $salesConfig, $layoutProcessors, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getJsLayout()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getJsLayout');
        return $pluginInfo ? $this->___callPlugins('getJsLayout', func_get_args(), $pluginInfo) : parent::getJsLayout();
    }
}
