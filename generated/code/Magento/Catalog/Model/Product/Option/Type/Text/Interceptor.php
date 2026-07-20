<?php
namespace Magento\Catalog\Model\Product\Option\Type\Text;

/**
 * Interceptor class for @see \Magento\Catalog\Model\Product\Option\Type\Text
 */
class Interceptor extends \Magento\Catalog\Model\Product\Option\Type\Text implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Checkout\Model\Session $checkoutSession, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Framework\Escaper $escaper, \Magento\Framework\Stdlib\StringUtils $string, array $data = [])
    {
        $this->___init();
        parent::__construct($checkoutSession, $scopeConfig, $escaper, $string, $data);
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
