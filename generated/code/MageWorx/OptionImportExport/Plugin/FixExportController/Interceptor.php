<?php
namespace MageWorx\OptionImportExport\Plugin\FixExportController;

/**
 * Interceptor class for @see \MageWorx\OptionImportExport\Plugin\FixExportController
 */
class Interceptor extends \MageWorx\OptionImportExport\Plugin\FixExportController implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\App\Response\Http\FileFactory $fileFactory, \Psr\Log\LoggerInterface $logger, \MageWorx\OptionBase\Helper\Data $baseHelper)
    {
        $this->___init();
        parent::__construct($context, $fileFactory, $logger, $baseHelper);
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
