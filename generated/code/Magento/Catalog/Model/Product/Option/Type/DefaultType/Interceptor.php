<?php
namespace Magento\Catalog\Model\Product\Option\Type\DefaultType;

/**
 * Interceptor class for @see \Magento\Catalog\Model\Product\Option\Type\DefaultType
 */
class Interceptor extends \Magento\Catalog\Model\Product\Option\Type\DefaultType implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Checkout\Model\Session $checkoutSession, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, array $data = [])
    {
        $this->___init();
        parent::__construct($checkoutSession, $scopeConfig, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function validateUserValue($values)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'validateUserValue');
        return $pluginInfo ? $this->___callPlugins('validateUserValue', func_get_args(), $pluginInfo) : parent::validateUserValue($values);
    }
}
