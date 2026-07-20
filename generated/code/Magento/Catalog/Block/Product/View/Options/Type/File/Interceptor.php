<?php
namespace Magento\Catalog\Block\Product\View\Options\Type\File;

/**
 * Interceptor class for @see \Magento\Catalog\Block\Product\View\Options\Type\File
 */
class Interceptor extends \Magento\Catalog\Block\Product\View\Options\Type\File implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Magento\Framework\Pricing\Helper\Data $pricingHelper, \Magento\Catalog\Helper\Data $catalogData, array $data = [], ?\Magento\Catalog\Pricing\Price\CalculateCustomOptionCatalogRule $calculateCustomOptionCatalogRule = null, ?\Magento\Framework\Pricing\Adjustment\CalculatorInterface $calculator = null, ?\Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency = null)
    {
        $this->___init();
        parent::__construct($context, $pricingHelper, $catalogData, $data, $calculateCustomOptionCatalogRule, $calculator, $priceCurrency);
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getTemplate');
        return $pluginInfo ? $this->___callPlugins('getTemplate', func_get_args(), $pluginInfo) : parent::getTemplate();
    }
}
