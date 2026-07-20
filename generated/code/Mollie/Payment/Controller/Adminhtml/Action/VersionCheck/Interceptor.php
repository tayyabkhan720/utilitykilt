<?php
namespace Mollie\Payment\Controller\Adminhtml\Action\VersionCheck;

/**
 * Interceptor class for @see \Mollie\Payment\Controller\Adminhtml\Action\VersionCheck
 */
class Interceptor extends \Mollie\Payment\Controller\Adminhtml\Action\VersionCheck implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory, \Magento\Framework\Serialize\Serializer\Json $json, \Mollie\Payment\Config $config, \Magento\Framework\Filesystem\Driver\File $file)
    {
        $this->___init();
        parent::__construct($context, $resultJsonFactory, $json, $config, $file);
    }

    /**
     * {@inheritdoc}
     */
    public function execute(): \Magento\Framework\Controller\Result\Json
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
