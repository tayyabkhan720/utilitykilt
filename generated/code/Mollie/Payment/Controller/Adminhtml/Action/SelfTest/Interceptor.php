<?php
namespace Mollie\Payment\Controller\Adminhtml\Action\SelfTest;

/**
 * Interceptor class for @see \Mollie\Payment\Controller\Adminhtml\Action\SelfTest
 */
class Interceptor extends \Mollie\Payment\Controller\Adminhtml\Action\SelfTest implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory, \Mollie\Payment\Helper\General $mollieHelper, array $tests)
    {
        $this->___init();
        parent::__construct($context, $resultJsonFactory, $mollieHelper, $tests);
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
