<?php
namespace Mollie\Payment\Controller\Adminhtml\Log\Download;

/**
 * Interceptor class for @see \Mollie\Payment\Controller\Adminhtml\Log\Download
 */
class Interceptor extends \Mollie\Payment\Controller\Adminhtml\Log\Download implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Mollie\Payment\Service\Config\Debug\DebugBundleGenerator $generator, \Magento\Framework\App\Response\Http\FileFactory $fileFactory, \Mollie\Payment\Logger\MollieLogger $logger, \Magento\Framework\AuthorizationInterface $authorization, \Magento\Framework\Message\ManagerInterface $messageManager, \Magento\Framework\Controller\ResultFactory $resultFactory)
    {
        $this->___init();
        parent::__construct($generator, $fileFactory, $logger, $authorization, $messageManager, $resultFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        return $pluginInfo ? $this->___callPlugins('execute', func_get_args(), $pluginInfo) : parent::execute();
    }
}
