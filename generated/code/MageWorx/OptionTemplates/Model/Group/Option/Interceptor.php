<?php
namespace MageWorx\OptionTemplates\Model\Group\Option;

/**
 * Interceptor class for @see \MageWorx\OptionTemplates\Model\Group\Option
 */
class Interceptor extends \MageWorx\OptionTemplates\Model\Group\Option implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\MageWorx\OptionBase\Helper\Data $baseHelper, \Magento\Framework\Model\Context $context, \Magento\Framework\Registry $registry, \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory, \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory, \MageWorx\OptionTemplates\Model\Group\Option\Value $productOptionValue, \Magento\Catalog\Model\Product\Option\Type\Factory $optionFactory, \Magento\Framework\Stdlib\StringUtils $string, \Magento\Catalog\Model\Product\Option\Validator\Pool $validatorPool, \Magento\Framework\DataObject\Factory $dataObjectFactory, ?\Magento\Framework\Model\ResourceModel\AbstractResource $resource = null, ?\Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null, array $data = [])
    {
        $this->___init();
        parent::__construct($baseHelper, $context, $registry, $extensionFactory, $customAttributeFactory, $productOptionValue, $optionFactory, $string, $validatorPool, $dataObjectFactory, $resource, $resourceCollection, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getPrice($flag = false)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getPrice');
        return $pluginInfo ? $this->___callPlugins('getPrice', func_get_args(), $pluginInfo) : parent::getPrice($flag);
    }
}
