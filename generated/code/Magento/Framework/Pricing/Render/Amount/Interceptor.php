<?php
namespace Magento\Framework\Pricing\Render\Amount;

/**
 * Interceptor class for @see \Magento\Framework\Pricing\Render\Amount
 */
class Interceptor extends \Magento\Framework\Pricing\Render\Amount implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Magento\Framework\Pricing\Amount\AmountInterface $amount, \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency, \Magento\Framework\Pricing\Render\RendererPool $rendererPool, ?\Magento\Framework\Pricing\SaleableInterface $saleableItem = null, ?\Magento\Framework\Pricing\Price\PriceInterface $price = null, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $amount, $priceCurrency, $rendererPool, $saleableItem, $price, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function toHtml()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'toHtml');
        return $pluginInfo ? $this->___callPlugins('toHtml', func_get_args(), $pluginInfo) : parent::toHtml();
    }
}
