<?php
namespace Magento\Checkout\Block\Total\DefaultTotal;

/**
 * Interceptor class for @see \Magento\Checkout\Block\Total\DefaultTotal
 */
class Interceptor extends \Magento\Checkout\Block\Total\DefaultTotal implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Magento\Customer\Model\Session $customerSession, \Magento\Checkout\Model\Session $checkoutSession, \Magento\Sales\Model\ConfigInterface $salesConfig, array $layoutProcessors = [], array $data = [], ?\Magento\Checkout\Helper\Data $checkoutHelper = null)
    {
        $this->___init();
        parent::__construct($context, $customerSession, $checkoutSession, $salesConfig, $layoutProcessors, $data, $checkoutHelper);
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
