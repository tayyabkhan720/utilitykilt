<?php
namespace Magento\Customer\Model\Address\DataProvider;

/**
 * Interceptor class for @see \Magento\Customer\Model\Address\DataProvider
 */
class Interceptor extends \Magento\Customer\Model\Address\DataProvider implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct($name, $primaryFieldName, $requestFieldName, \Magento\Customer\Model\ResourceModel\Address\CollectionFactory $addressCollectionFactory, \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository, \Magento\Eav\Model\Config $eavConfig, \Magento\Framework\View\Element\UiComponent\ContextInterface $context, \Magento\Customer\Model\FileUploaderDataResolver $fileUploaderDataResolver, \Magento\Customer\Model\AttributeMetadataResolver $attributeMetadataResolver, array $meta = [], array $data = [], $allowToShowHiddenAttributes = true, ?\Magento\Customer\Model\AddressRegistry $addressRegistry = null)
    {
        $this->___init();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $addressCollectionFactory, $customerRepository, $eavConfig, $context, $fileUploaderDataResolver, $attributeMetadataResolver, $meta, $data, $allowToShowHiddenAttributes, $addressRegistry);
    }

    /**
     * {@inheritdoc}
     */
    public function getMeta()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getMeta');
        return $pluginInfo ? $this->___callPlugins('getMeta', func_get_args(), $pluginInfo) : parent::getMeta();
    }
}
