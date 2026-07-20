<?php
namespace MageWorx\OptionBase\Model\OptionSaver\Option;

/**
 * Interceptor class for @see \MageWorx\OptionBase\Model\OptionSaver\Option
 */
class Interceptor extends \MageWorx\OptionBase\Model\OptionSaver\Option implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Model\ResourceModel\Db\Context $context, \Magento\Directory\Model\CurrencyFactory $currencyFactory, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\App\Config\ScopeConfigInterface $config, \MageWorx\OptionBase\Model\OptionSaver\Value $optionValueDataCollector, \Magento\Catalog\Api\ProductCustomOptionRepositoryInterface $optionRepository, \MageWorx\OptionBase\Model\Product\Option\Attributes $optionAttributes, \MageWorx\OptionBase\Helper\Data $baseHelper, $connectionName = null)
    {
        $this->___init();
        parent::__construct($context, $currencyFactory, $storeManager, $config, $optionValueDataCollector, $optionRepository, $optionAttributes, $baseHelper, $connectionName);
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
