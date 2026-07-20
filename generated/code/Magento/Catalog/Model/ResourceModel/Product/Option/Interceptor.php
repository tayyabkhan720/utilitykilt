<?php
namespace Magento\Catalog\Model\ResourceModel\Product\Option;

/**
 * Interceptor class for @see \Magento\Catalog\Model\ResourceModel\Product\Option
 */
class Interceptor extends \Magento\Catalog\Model\ResourceModel\Product\Option implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Model\ResourceModel\Db\Context $context, \Magento\Directory\Model\CurrencyFactory $currencyFactory, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\App\Config\ScopeConfigInterface $config, $connectionName = null)
    {
        $this->___init();
        parent::__construct($context, $currencyFactory, $storeManager, $config, $connectionName);
    }

    /**
     * {@inheritdoc}
     */
    public function duplicate(\Magento\Catalog\Model\Product\Option $object, $oldProductId, $newProductId)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'duplicate');
        return $pluginInfo ? $this->___callPlugins('duplicate', func_get_args(), $pluginInfo) : parent::duplicate($object, $oldProductId, $newProductId);
    }
}
