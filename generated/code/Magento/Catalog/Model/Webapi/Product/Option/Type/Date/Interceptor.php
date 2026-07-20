<?php
namespace Magento\Catalog\Model\Webapi\Product\Option\Type\Date;

/**
 * Interceptor class for @see \Magento\Catalog\Model\Webapi\Product\Option\Type\Date
 */
class Interceptor extends \Magento\Catalog\Model\Webapi\Product\Option\Type\Date implements \Magento\Framework\Interception\InterceptorInterface
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
