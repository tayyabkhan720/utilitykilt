<?php
namespace Magento\Catalog\Model\Config\Source\Product\Options\Price;

/**
 * Interceptor class for @see \Magento\Catalog\Model\Config\Source\Product\Options\Price
 */
class Interceptor extends \Magento\Catalog\Model\Config\Source\Product\Options\Price implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Store\Model\StoreManagerInterface $storeManager)
    {
        $this->___init();
        parent::__construct($storeManager);
    }

    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'toOptionArray');
        return $pluginInfo ? $this->___callPlugins('toOptionArray', func_get_args(), $pluginInfo) : parent::toOptionArray();
    }

    /**
     * {@inheritdoc}
     */
    public function prefixesToOptionArray()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'prefixesToOptionArray');
        return $pluginInfo ? $this->___callPlugins('prefixesToOptionArray', func_get_args(), $pluginInfo) : parent::prefixesToOptionArray();
    }
}
