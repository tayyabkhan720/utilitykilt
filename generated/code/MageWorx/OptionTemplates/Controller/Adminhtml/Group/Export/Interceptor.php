<?php
namespace MageWorx\OptionTemplates\Controller\Adminhtml\Group\Export;

/**
 * Interceptor class for @see \MageWorx\OptionTemplates\Controller\Adminhtml\Group\Export
 */
class Interceptor extends \MageWorx\OptionTemplates\Controller\Adminhtml\Group\Export implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Ui\Component\MassAction\Filter $filter, \MageWorx\OptionTemplates\Model\ResourceModel\Group\CollectionFactory $collectionFactory, \MageWorx\OptionTemplates\Model\Group\Copier $groupCopier, \MageWorx\OptionTemplates\Controller\Adminhtml\Group\Builder $groupBuilder, \Magento\Backend\App\Action\Context $context, \Magento\Framework\App\Response\Http\FileFactory $fileFactory, \MageWorx\OptionBase\Model\Entity\Base $groupBaseEntity, \Magento\Framework\App\Filesystem\DirectoryList $directoryList, \Magento\Framework\Serialize\Serializer\Json $serializer)
    {
        $this->___init();
        parent::__construct($filter, $collectionFactory, $groupCopier, $groupBuilder, $context, $fileFactory, $groupBaseEntity, $directoryList, $serializer);
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
