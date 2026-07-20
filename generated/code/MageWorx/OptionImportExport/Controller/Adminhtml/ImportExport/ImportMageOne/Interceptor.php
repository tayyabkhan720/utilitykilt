<?php
namespace MageWorx\OptionImportExport\Controller\Adminhtml\ImportExport\ImportMageOne;

/**
 * Interceptor class for @see \MageWorx\OptionImportExport\Controller\Adminhtml\ImportExport\ImportMageOne
 */
class Interceptor extends \MageWorx\OptionImportExport\Controller\Adminhtml\ImportExport\ImportMageOne implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Psr\Log\LoggerInterface $logger, \Magento\Backend\Model\Session $backendSession, \MageWorx\OptionImportExport\Model\MageOne\ImportTemplateHandler $importTemplateHandler, \MageWorx\OptionImportExport\Model\MageOne\ImportOptionsHandler $importOptionsHandler, \MageWorx\OptionBase\Model\ActionMode $actionMode)
    {
        $this->___init();
        parent::__construct($context, $logger, $backendSession, $importTemplateHandler, $importOptionsHandler, $actionMode);
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
