<?php
namespace Magento\Tax\Block\Checkout\Subtotal;

/**
 * Interceptor class for @see \Magento\Tax\Block\Checkout\Subtotal
 */
class Interceptor extends \Magento\Tax\Block\Checkout\Subtotal implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Magento\Customer\Model\Session $customerSession, \Magento\Checkout\Model\Session $checkoutSession, \Magento\Sales\Model\ConfigInterface $salesConfig, \Magento\Tax\Model\Config $taxConfig, array $layoutProcessors = [], array $data = [])
    {
        $this->___init();
        parent::__construct($context, $customerSession, $checkoutSession, $salesConfig, $taxConfig, $layoutProcessors, $data);
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
