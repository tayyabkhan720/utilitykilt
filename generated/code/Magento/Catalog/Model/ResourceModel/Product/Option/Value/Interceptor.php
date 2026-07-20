<?php
namespace Magento\Catalog\Model\ResourceModel\Product\Option\Value;

/**
 * Interceptor class for @see \Magento\Catalog\Model\ResourceModel\Product\Option\Value
 */
class Interceptor extends \Magento\Catalog\Model\ResourceModel\Product\Option\Value implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Model\ResourceModel\Db\Context $context, \Magento\Directory\Model\CurrencyFactory $currencyFactory, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\App\Config\ScopeConfigInterface $config, $connectionName = null, ?\Magento\Catalog\Helper\Data $dataHelper = null)
    {
        $this->___init();
        parent::__construct($context, $currencyFactory, $storeManager, $config, $connectionName, $dataHelper);
    }

    /**
     * {@inheritdoc}
     */
    public function duplicate(\Magento\Catalog\Model\Product\Option\Value $object, $oldOptionId, $newOptionId)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'duplicate');
        return $pluginInfo ? $this->___callPlugins('duplicate', func_get_args(), $pluginInfo) : parent::duplicate($object, $oldOptionId, $newOptionId);
    }
}
