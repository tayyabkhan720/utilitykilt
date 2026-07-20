<?php
namespace MageWorx\OptionBase\Helper\Data;

/**
 * Interceptor class for @see \MageWorx\OptionBase\Helper\Data
 */
class Interceptor extends \MageWorx\OptionBase\Helper\Data implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\ProductMetadataInterface $productMetadata, \Magento\Framework\ObjectManagerInterface $objectManager, \Magento\Framework\App\Helper\Context $context, \Magento\Framework\Component\ComponentRegistrarInterface $componentRegistrar, \Magento\Framework\Filesystem\Directory\ReadFactory $readFactory, \Magento\Framework\Message\ManagerInterface $messageManager, \Magento\Framework\App\ResponseInterface $response, \Magento\Framework\Module\ModuleList $moduleList, \Magento\Framework\Serialize\Serializer\Json $jsonHelper, \MageWorx\OptionBase\Model\ActionMode $actionMode, \Magento\Framework\App\ResourceConnection $resource, $linkedAttributes = [], $isDisabledConfigPath = null, $isEnabledVisibilityPerCustomerGroup = null, $isEnabledVisibilityPerStoreView = null, $configPathInventoryOutOfStockOptions = '')
    {
        $this->___init();
        parent::__construct($productMetadata, $objectManager, $context, $componentRegistrar, $readFactory, $messageManager, $response, $moduleList, $jsonHelper, $actionMode, $resource, $linkedAttributes, $isDisabledConfigPath, $isEnabledVisibilityPerCustomerGroup, $isEnabledVisibilityPerStoreView, $configPathInventoryOutOfStockOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function isHiddenOutOfStockOptions($storeId = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isHiddenOutOfStockOptions');
        return $pluginInfo ? $this->___callPlugins('isHiddenOutOfStockOptions', func_get_args(), $pluginInfo) : parent::isHiddenOutOfStockOptions($storeId);
    }

    /**
     * {@inheritdoc}
     */
    public function isDisabledOutOfStockOptions($storeId = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isDisabledOutOfStockOptions');
        return $pluginInfo ? $this->___callPlugins('isDisabledOutOfStockOptions', func_get_args(), $pluginInfo) : parent::isDisabledOutOfStockOptions($storeId);
    }
}
