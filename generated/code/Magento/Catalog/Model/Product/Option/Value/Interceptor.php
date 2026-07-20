<?php
namespace Magento\Catalog\Model\Product\Option\Value;

/**
 * Interceptor class for @see \Magento\Catalog\Model\Product\Option\Value
 */
class Interceptor extends \Magento\Catalog\Model\Product\Option\Value implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Model\Context $context, \Magento\Framework\Registry $registry, \Magento\Catalog\Model\ResourceModel\Product\Option\Value\CollectionFactory $valueCollectionFactory, ?\Magento\Framework\Model\ResourceModel\AbstractResource $resource = null, ?\Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null, array $data = [], ?\Magento\Catalog\Pricing\Price\CustomOptionPriceCalculator $customOptionPriceCalculator = null)
    {
        $this->___init();
        parent::__construct($context, $registry, $valueCollectionFactory, $resource, $resourceCollection, $data, $customOptionPriceCalculator);
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
