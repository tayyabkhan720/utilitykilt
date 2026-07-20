<?php
namespace MageWorx\OptionTemplates\Controller\Adminhtml\Group\Save;

/**
 * Interceptor class for @see \MageWorx\OptionTemplates\Controller\Adminhtml\Group\Save
 */
class Interceptor extends \MageWorx\OptionTemplates\Controller\Adminhtml\Group\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory, \MageWorx\OptionTemplates\Model\OptionSaver $optionSaver, \Magento\Backend\Helper\Js $jsHelper, \MageWorx\OptionTemplates\Controller\Adminhtml\Group\Builder $groupBuilder, \MageWorx\OptionTemplates\Model\GroupFactory $groupFactory, \MageWorx\OptionTemplates\Model\Group\Option $groupOptionModel, \MageWorx\OptionTemplates\Model\Group\OptionFactory $groupOptionFactory, \MageWorx\OptionBase\Model\Product\Attributes $productAttributes, \Magento\Backend\App\Action\Context $context, \MageWorx\OptionTemplates\Model\Group\Copier $groupCopier, \Magento\Framework\Registry $registry, \Magento\Framework\Serialize\Serializer\Json $serializer)
    {
        $this->___init();
        parent::__construct($productCollectionFactory, $optionSaver, $jsHelper, $groupBuilder, $groupFactory, $groupOptionModel, $groupOptionFactory, $productAttributes, $context, $groupCopier, $registry, $serializer);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        return $pluginInfo ? $this->___callPlugins('execute', func_get_args(), $pluginInfo) : parent::execute();
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(\Magento\Framework\App\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'dispatch');
        return $pluginInfo ? $this->___callPlugins('dispatch', func_get_args(), $pluginInfo) : parent::dispatch($request);
    }
}
