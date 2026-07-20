<?php
namespace Magento\Tax\Model\Config;

/**
 * Interceptor class for @see \Magento\Tax\Model\Config
 */
class Interceptor extends \Magento\Tax\Model\Config implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig)
    {
        $this->___init();
        parent::__construct($scopeConfig);
    }

    /**
     * {@inheritdoc}
     */
    public function priceIncludesTax($store = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'priceIncludesTax');
        return $pluginInfo ? $this->___callPlugins('priceIncludesTax', func_get_args(), $pluginInfo) : parent::priceIncludesTax($store);
    }

    /**
     * {@inheritdoc}
     */
    public function applyTaxAfterDiscount($store = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'applyTaxAfterDiscount');
        return $pluginInfo ? $this->___callPlugins('applyTaxAfterDiscount', func_get_args(), $pluginInfo) : parent::applyTaxAfterDiscount($store);
    }

    /**
     * {@inheritdoc}
     */
    public function getPriceDisplayType($store = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getPriceDisplayType');
        return $pluginInfo ? $this->___callPlugins('getPriceDisplayType', func_get_args(), $pluginInfo) : parent::getPriceDisplayType($store);
    }

    /**
     * {@inheritdoc}
     */
    public function discountTax($store = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'discountTax');
        return $pluginInfo ? $this->___callPlugins('discountTax', func_get_args(), $pluginInfo) : parent::discountTax($store);
    }

    /**
     * {@inheritdoc}
     */
    public function getAlgorithm($store = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getAlgorithm');
        return $pluginInfo ? $this->___callPlugins('getAlgorithm', func_get_args(), $pluginInfo) : parent::getAlgorithm($store);
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingTaxClass($store = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getShippingTaxClass');
        return $pluginInfo ? $this->___callPlugins('getShippingTaxClass', func_get_args(), $pluginInfo) : parent::getShippingTaxClass($store);
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingPriceDisplayType($store = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getShippingPriceDisplayType');
        return $pluginInfo ? $this->___callPlugins('getShippingPriceDisplayType', func_get_args(), $pluginInfo) : parent::getShippingPriceDisplayType($store);
    }

    /**
     * {@inheritdoc}
     */
    public function shippingPriceIncludesTax($store = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'shippingPriceIncludesTax');
        return $pluginInfo ? $this->___callPlugins('shippingPriceIncludesTax', func_get_args(), $pluginInfo) : parent::shippingPriceIncludesTax($store);
    }

    /**
     * {@inheritdoc}
     */
    public function crossBorderTradeEnabled($store = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'crossBorderTradeEnabled');
        return $pluginInfo ? $this->___callPlugins('crossBorderTradeEnabled', func_get_args(), $pluginInfo) : parent::crossBorderTradeEnabled($store);
    }
}
