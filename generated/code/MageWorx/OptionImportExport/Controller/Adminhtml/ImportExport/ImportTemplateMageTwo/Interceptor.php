<?php
namespace MageWorx\OptionImportExport\Controller\Adminhtml\ImportExport\ImportTemplateMageTwo;

/**
 * Interceptor class for @see \MageWorx\OptionImportExport\Controller\Adminhtml\ImportExport\ImportTemplateMageTwo
 */
class Interceptor extends \MageWorx\OptionImportExport\Controller\Adminhtml\ImportExport\ImportTemplateMageTwo implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Psr\Log\LoggerInterface $logger, \Magento\Backend\Model\Session $backendSession, \MageWorx\OptionImportExport\Model\MageTwo\ImportTemplateHandler $importTemplateHandler, \MageWorx\OptionBase\Model\ActionMode $actionMode)
    {
        $this->___init();
        parent::__construct($context, $logger, $backendSession, $importTemplateHandler, $actionMode);
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
