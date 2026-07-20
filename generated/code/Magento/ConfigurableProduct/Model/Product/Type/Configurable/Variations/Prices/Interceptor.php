<?php
namespace Magento\ConfigurableProduct\Model\Product\Type\Configurable\Variations\Prices;

/**
 * Interceptor class for @see \Magento\ConfigurableProduct\Model\Product\Type\Configurable\Variations\Prices
 */
class Interceptor extends \Magento\ConfigurableProduct\Model\Product\Type\Configurable\Variations\Prices implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Locale\Format $localeFormat)
    {
        $this->___init();
        parent::__construct($localeFormat);
    }

    /**
     * {@inheritdoc}
     */
    public function getFormattedPrices(\Magento\Framework\Pricing\PriceInfo\Base $priceInfo)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getFormattedPrices');
        return $pluginInfo ? $this->___callPlugins('getFormattedPrices', func_get_args(), $pluginInfo) : parent::getFormattedPrices($priceInfo);
    }
}
