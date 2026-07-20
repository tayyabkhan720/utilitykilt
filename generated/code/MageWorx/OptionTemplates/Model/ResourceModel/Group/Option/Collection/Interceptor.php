<?php
namespace MageWorx\OptionTemplates\Model\ResourceModel\Group\Option\Collection;

/**
 * Interceptor class for @see \MageWorx\OptionTemplates\Model\ResourceModel\Group\Option\Collection
 */
class Interceptor extends \MageWorx\OptionTemplates\Model\ResourceModel\Group\Option\Collection implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Data\Collection\EntityFactory $entityFactory, \Psr\Log\LoggerInterface $logger, \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy, \Magento\Framework\Event\ManagerInterface $eventManager, \MageWorx\OptionTemplates\Model\ResourceModel\Group\Option\Value\CollectionFactory $valueCollectionFactory, \Magento\Store\Model\StoreManagerInterface $storeManager, \MageWorx\OptionBase\Model\ResourceModel\CollectionUpdaterRegistry $collectionUpdaterRegistry, ?\Magento\Framework\DB\Adapter\AdapterInterface $connection = null, ?\Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null)
    {
        $this->___init();
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $valueCollectionFactory, $storeManager, $collectionUpdaterRegistry, $connection, $resource);
    }

    /**
     * {@inheritdoc}
     */
    public function addValuesToResult($storeId = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addValuesToResult');
        return $pluginInfo ? $this->___callPlugins('addValuesToResult', func_get_args(), $pluginInfo) : parent::addValuesToResult($storeId);
    }

    /**
     * {@inheritdoc}
     */
    public function getProductOptions($productId, $storeId, $requiredOnly = false)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProductOptions');
        return $pluginInfo ? $this->___callPlugins('getProductOptions', func_get_args(), $pluginInfo) : parent::getProductOptions($productId, $storeId, $requiredOnly);
    }

    /**
     * {@inheritdoc}
     */
    public function load($printQuery = false, $logQuery = false)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'load');
        return $pluginInfo ? $this->___callPlugins('load', func_get_args(), $pluginInfo) : parent::load($printQuery, $logQuery);
    }

    /**
     * {@inheritdoc}
     */
    public function getCurPage($displacement = 0)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getCurPage');
        return $pluginInfo ? $this->___callPlugins('getCurPage', func_get_args(), $pluginInfo) : parent::getCurPage($displacement);
    }
}
