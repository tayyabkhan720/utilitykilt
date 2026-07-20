<?php
namespace MageWorx\OptionTemplates\Model\Group\Option\Value;

/**
 * Interceptor class for @see \MageWorx\OptionTemplates\Model\Group\Option\Value
 */
class Interceptor extends \MageWorx\OptionTemplates\Model\Group\Option\Value implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\MageWorx\OptionBase\Helper\Data $baseHelper, \Magento\Framework\Model\Context $context, \Magento\Framework\Registry $registry, \MageWorx\OptionTemplates\Model\ResourceModel\Group\Option\Value\CollectionFactory $valueCollectionFactory, ?\Magento\Framework\Model\ResourceModel\AbstractResource $resource = null, ?\Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null, array $data = [])
    {
        $this->___init();
        parent::__construct($baseHelper, $context, $registry, $valueCollectionFactory, $resource, $resourceCollection, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function saveValues()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'saveValues');
        return $pluginInfo ? $this->___callPlugins('saveValues', func_get_args(), $pluginInfo) : parent::saveValues();
    }
}
