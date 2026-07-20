<?php
namespace Magento\Tax\Pricing\Render\Adjustment;

/**
 * Interceptor class for @see \Magento\Tax\Pricing\Render\Adjustment
 */
class Interceptor extends \Magento\Tax\Pricing\Render\Adjustment implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency, \Magento\Tax\Helper\Data $helper, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $priceCurrency, $helper, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getDataPriceType(): string
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getDataPriceType');
        return $pluginInfo ? $this->___callPlugins('getDataPriceType', func_get_args(), $pluginInfo) : parent::getDataPriceType();
    }

    /**
     * {@inheritdoc}
     */
    public function render(\Magento\Framework\Pricing\Render\AmountRenderInterface $amountRender, array $arguments = [])
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'render');
        return $pluginInfo ? $this->___callPlugins('render', func_get_args(), $pluginInfo) : parent::render($amountRender, $arguments);
    }
}
