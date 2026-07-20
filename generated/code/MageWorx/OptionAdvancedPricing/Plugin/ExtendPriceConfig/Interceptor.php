<?php
namespace MageWorx\OptionAdvancedPricing\Plugin\ExtendPriceConfig;

/**
 * Interceptor class for @see \MageWorx\OptionAdvancedPricing\Plugin\ExtendPriceConfig
 */
class Interceptor extends \MageWorx\OptionAdvancedPricing\Plugin\ExtendPriceConfig implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Magento\Framework\Pricing\Helper\Data $pricingHelper, \Magento\Catalog\Helper\Data $catalogData, \Magento\Framework\Json\EncoderInterface $jsonEncoder, \Magento\Catalog\Model\Product\Option $option, \Magento\Framework\Registry $registry, \Magento\Framework\Stdlib\ArrayUtils $arrayUtils, \MageWorx\OptionAdvancedPricing\Helper\Data $helper, \MageWorx\OptionAdvancedPricing\Model\SpecialPrice $specialPriceModel, \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency, \MageWorx\OptionBase\Helper\Price $basePriceHelper, \Magento\Framework\Json\DecoderInterface $jsonDecoder, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $pricingHelper, $catalogData, $jsonEncoder, $option, $registry, $arrayUtils, $helper, $specialPriceModel, $priceCurrency, $basePriceHelper, $jsonDecoder, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getJsonConfig()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getJsonConfig');
        return $pluginInfo ? $this->___callPlugins('getJsonConfig', func_get_args(), $pluginInfo) : parent::getJsonConfig();
    }

    /**
     * {@inheritdoc}
     */
    public function getOptionHtml(\Magento\Catalog\Model\Product\Option $option)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getOptionHtml');
        return $pluginInfo ? $this->___callPlugins('getOptionHtml', func_get_args(), $pluginInfo) : parent::getOptionHtml($option);
    }
}
