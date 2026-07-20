<?php
namespace Magento\Downloadable\Model\Product\Type;

/**
 * Interceptor class for @see \Magento\Downloadable\Model\Product\Type
 */
class Interceptor extends \Magento\Downloadable\Model\Product\Type implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Model\Product\Option $catalogProductOption, \Magento\Eav\Model\Config $eavConfig, \Magento\Catalog\Model\Product\Type $catalogProductType, \Magento\Framework\Event\ManagerInterface $eventManager, \Magento\MediaStorage\Helper\File\Storage\Database $fileStorageDb, \Magento\Framework\Filesystem $filesystem, \Magento\Framework\Registry $coreRegistry, \Psr\Log\LoggerInterface $logger, \Magento\Catalog\Api\ProductRepositoryInterface $productRepository, \Magento\Downloadable\Model\ResourceModel\SampleFactory $sampleResFactory, \Magento\Downloadable\Model\ResourceModel\Link $linkResource, \Magento\Downloadable\Model\ResourceModel\Link\CollectionFactory $linksFactory, \Magento\Downloadable\Model\ResourceModel\Sample\CollectionFactory $samplesFactory, \Magento\Downloadable\Model\SampleFactory $sampleFactory, \Magento\Downloadable\Model\LinkFactory $linkFactory, \Magento\Downloadable\Model\Product\TypeHandler\TypeHandlerInterface $typeHandler, \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface $extensionAttributesJoinProcessor, ?\Magento\Framework\Serialize\Serializer\Json $serializer = null, ?\Magento\Framework\File\UploaderFactory $uploaderFactory = null)
    {
        $this->___init();
        parent::__construct($catalogProductOption, $eavConfig, $catalogProductType, $eventManager, $fileStorageDb, $filesystem, $coreRegistry, $logger, $productRepository, $sampleResFactory, $linkResource, $linksFactory, $samplesFactory, $sampleFactory, $linkFactory, $typeHandler, $extensionAttributesJoinProcessor, $serializer, $uploaderFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function hasRequiredOptions($product)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'hasRequiredOptions');
        return $pluginInfo ? $this->___callPlugins('hasRequiredOptions', func_get_args(), $pluginInfo) : parent::hasRequiredOptions($product);
    }

    /**
     * {@inheritdoc}
     */
    public function checkProductBuyState($product)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'checkProductBuyState');
        return $pluginInfo ? $this->___callPlugins('checkProductBuyState', func_get_args(), $pluginInfo) : parent::checkProductBuyState($product);
    }

    /**
     * {@inheritdoc}
     */
    public function isPossibleBuyFromList($product)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isPossibleBuyFromList');
        return $pluginInfo ? $this->___callPlugins('isPossibleBuyFromList', func_get_args(), $pluginInfo) : parent::isPossibleBuyFromList($product);
    }
}
