<?php
namespace MageWorx\OptionTemplates\Model\ResourceModel\Product;

/**
 * Interceptor class for @see \MageWorx\OptionTemplates\Model\ResourceModel\Product
 */
class Interceptor extends \MageWorx\OptionTemplates\Model\ResourceModel\Product implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Eav\Model\Entity\Context $context, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Catalog\Model\Factory $modelFactory, \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory, \Magento\Catalog\Model\ResourceModel\Category $catalogCategory, \Magento\Framework\Event\ManagerInterface $eventManager, \Magento\Eav\Model\Entity\Attribute\SetFactory $setFactory, \Magento\Eav\Model\Entity\TypeFactory $typeFactory, \Magento\Catalog\Model\Product\Attribute\DefaultAttributes $defaultAttributes, $data = [], ?\Magento\Catalog\Model\Indexer\Category\Product\TableMaintainer $tableMaintainer = null, ?\Magento\Eav\Model\Entity\Attribute\UniqueValidationInterface $uniqueValidator = null, ?\Magento\Eav\Api\AttributeManagementInterface $eavAttributeManagement = null, ?\Magento\Catalog\Model\ResourceModel\MediaImageDeleteProcessor $mediaImageDeleteProcessor = null, ?\Magento\Catalog\Model\Attribute\ScopeOverriddenValue $scopeOverriddenValue = null)
    {
        $this->___init();
        parent::__construct($context, $storeManager, $modelFactory, $categoryCollectionFactory, $catalogCategory, $eventManager, $setFactory, $typeFactory, $defaultAttributes, $data, $tableMaintainer, $uniqueValidator, $eavAttributeManagement, $mediaImageDeleteProcessor, $scopeOverriddenValue);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($object)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'delete');
        return $pluginInfo ? $this->___callPlugins('delete', func_get_args(), $pluginInfo) : parent::delete($object);
    }

    /**
     * {@inheritdoc}
     */
    public function duplicate($oldId, $newId)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'duplicate');
        return $pluginInfo ? $this->___callPlugins('duplicate', func_get_args(), $pluginInfo) : parent::duplicate($oldId, $newId);
    }

    /**
     * {@inheritdoc}
     */
    public function save(\Magento\Framework\Model\AbstractModel $object)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'save');
        return $pluginInfo ? $this->___callPlugins('save', func_get_args(), $pluginInfo) : parent::save($object);
    }
}
