<?php
namespace MageWorx\Info\Controller\Adminhtml\ExtensionInfo\Update;

/**
 * Interceptor class for @see \MageWorx\Info\Controller\Adminhtml\ExtensionInfo\Update
 */
class Interceptor extends \MageWorx\Info\Controller\Adminhtml\ExtensionInfo\Update implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\MageWorx\Info\Helper\Data $helper, \Magento\Backend\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($helper, $context);
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
