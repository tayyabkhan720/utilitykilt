<?php
namespace Magento\Catalog\Block\Product\View\Options;

/**
 * Interceptor class for @see \Magento\Catalog\Block\Product\View\Options
 */
class Interceptor extends \Magento\Catalog\Block\Product\View\Options implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Magento\Framework\Pricing\Helper\Data $pricingHelper, \Magento\Catalog\Helper\Data $catalogData, \Magento\Framework\Json\EncoderInterface $jsonEncoder, \Magento\Catalog\Model\Product\Option $option, \Magento\Framework\Registry $registry, \Magento\Framework\Stdlib\ArrayUtils $arrayUtils, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $pricingHelper, $catalogData, $jsonEncoder, $option, $registry, $arrayUtils, $data);
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
