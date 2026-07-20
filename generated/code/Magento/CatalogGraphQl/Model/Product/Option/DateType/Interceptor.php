<?php
namespace Magento\CatalogGraphQl\Model\Product\Option\DateType;

/**
 * Interceptor class for @see \Magento\CatalogGraphQl\Model\Product\Option\DateType
 */
class Interceptor extends \Magento\CatalogGraphQl\Model\Product\Option\DateType implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Checkout\Model\Session $checkoutSession, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate, array $data = [], ?\Magento\Framework\Serialize\Serializer\Json $serializer = null)
    {
        $this->___init();
        parent::__construct($checkoutSession, $scopeConfig, $localeDate, $data, $serializer);
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
