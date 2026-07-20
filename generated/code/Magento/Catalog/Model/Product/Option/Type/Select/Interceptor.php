<?php
namespace Magento\Catalog\Model\Product\Option\Type\Select;

/**
 * Interceptor class for @see \Magento\Catalog\Model\Product\Option\Type\Select
 */
class Interceptor extends \Magento\Catalog\Model\Product\Option\Type\Select implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Checkout\Model\Session $checkoutSession, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Framework\Stdlib\StringUtils $string, \Magento\Framework\Escaper $escaper, array $data = [], array $singleSelectionTypes = [])
    {
        $this->___init();
        parent::__construct($checkoutSession, $scopeConfig, $string, $escaper, $data, $singleSelectionTypes);
    }

    /**
     * {@inheritdoc}
     */
    public function validateUserValue($values)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'validateUserValue');
        return $pluginInfo ? $this->___callPlugins('validateUserValue', func_get_args(), $pluginInfo) : parent::validateUserValue($values);
    }

    /**
     * {@inheritdoc}
     */
    public function getEditableOptionValue($optionValue)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getEditableOptionValue');
        return $pluginInfo ? $this->___callPlugins('getEditableOptionValue', func_get_args(), $pluginInfo) : parent::getEditableOptionValue($optionValue);
    }

    /**
     * {@inheritdoc}
     */
    public function getOptionPrice($optionValue, $basePrice)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getOptionPrice');
        return $pluginInfo ? $this->___callPlugins('getOptionPrice', func_get_args(), $pluginInfo) : parent::getOptionPrice($optionValue, $basePrice);
    }
}
