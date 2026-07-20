<?php
namespace MageWorx\OptionImportExport\Model\MageTwo\Import\Product\Option;

/**
 * Interceptor class for @see \MageWorx\OptionImportExport\Model\MageTwo\Import\Product\Option
 */
class Interceptor extends \MageWorx\OptionImportExport\Model\MageTwo\Import\Product\Option implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\MageWorx\OptionTemplates\Model\ResourceModel\Group $groupResourceModel, \Magento\Framework\Event\ManagerInterface $eventManager, \Magento\ImportExport\Model\ResourceModel\Import\Data $importData, \Magento\Framework\App\ResourceConnection $resource, \MageWorx\OptionBase\Model\AttributeSaver $attributeSaver, \Psr\Log\LoggerInterface $logger, \Magento\Framework\Message\ManagerInterface $messageManager, \MageWorx\OptionBase\Model\ResourceModel\DataSaver $dataSaver, \Magento\ImportExport\Model\ResourceModel\Helper $resourceHelper, \Magento\Store\Model\StoreManagerInterface $_storeManager, \Magento\Catalog\Model\ProductFactory $productFactory, \Magento\Catalog\Model\ResourceModel\Product\Option\CollectionFactory $optionColFactory, \Magento\ImportExport\Model\ResourceModel\CollectionByPagesIteratorFactory $colIteratorFactory, \Magento\Catalog\Helper\Data $catalogData, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Framework\Stdlib\DateTime\TimezoneInterface $dateTime, \Magento\ImportExport\Model\Import\ErrorProcessing\ProcessingErrorAggregatorInterface $errorAggregator, \MageWorx\OptionBase\Model\Product\Attributes $productAttributes, \MageWorx\OptionBase\Model\Product\Option\Attributes $optionAttributes, \MageWorx\OptionBase\Model\Product\Option\Value\Attributes $valueAttributes, array $data = [], ?\Magento\Catalog\Model\ResourceModel\Product\Option\Value\CollectionFactory $productOptionValueCollectionFactory = null)
    {
        $this->___init();
        parent::__construct($groupResourceModel, $eventManager, $importData, $resource, $attributeSaver, $logger, $messageManager, $dataSaver, $resourceHelper, $_storeManager, $productFactory, $optionColFactory, $colIteratorFactory, $catalogData, $scopeConfig, $dateTime, $errorAggregator, $productAttributes, $optionAttributes, $valueAttributes, $data, $productOptionValueCollectionFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function importData()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'importData');
        return $pluginInfo ? $this->___callPlugins('importData', func_get_args(), $pluginInfo) : parent::importData();
    }

    /**
     * {@inheritdoc}
     */
    public function isNeedToLogInHistory()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isNeedToLogInHistory');
        return $pluginInfo ? $this->___callPlugins('isNeedToLogInHistory', func_get_args(), $pluginInfo) : parent::isNeedToLogInHistory();
    }

    /**
     * {@inheritdoc}
     */
    public function validateData()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'validateData');
        return $pluginInfo ? $this->___callPlugins('validateData', func_get_args(), $pluginInfo) : parent::validateData();
    }
}
