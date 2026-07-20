<?php
namespace MageWorx\OptionTemplates\Model\ResourceModel\Group\Option;

/**
 * Interceptor class for @see \MageWorx\OptionTemplates\Model\ResourceModel\Group\Option
 */
class Interceptor extends \MageWorx\OptionTemplates\Model\ResourceModel\Group\Option implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Model\ResourceModel\Db\Context $context, \Magento\Directory\Model\CurrencyFactory $currencyFactory, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\App\Config\ScopeConfigInterface $config, \MageWorx\OptionTemplates\Model\ResourceModel\Group\Option\Value $valueResourceModel, \MageWorx\OptionBase\Model\Product\Option\Attributes $optionAttributes, \Magento\Framework\Registry $registry, $connectionName = null)
    {
        $this->___init();
        parent::__construct($context, $currencyFactory, $storeManager, $config, $valueResourceModel, $optionAttributes, $registry, $connectionName);
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
