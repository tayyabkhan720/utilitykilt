<?php
namespace Magento\Tax\Block\Checkout\Tax;

/**
 * Interceptor class for @see \Magento\Tax\Block\Checkout\Tax
 */
class Interceptor extends \Magento\Tax\Block\Checkout\Tax implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Magento\Customer\Model\Session $customerSession, \Magento\Checkout\Model\Session $checkoutSession, \Magento\Sales\Model\ConfigInterface $salesConfig, array $layoutProcessors = [], array $data = [], ?\Magento\Checkout\Helper\Data $checkoutHelper = null, ?\Magento\Tax\Helper\Data $taxHelper = null)
    {
        $this->___init();
        parent::__construct($context, $customerSession, $checkoutSession, $salesConfig, $layoutProcessors, $data, $checkoutHelper, $taxHelper);
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
