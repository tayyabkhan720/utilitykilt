<?php
namespace Amasty\CheckoutCore\Controller\Adminhtml\Field\Save;

/**
 * Interceptor class for @see \Amasty\CheckoutCore\Controller\Adminhtml\Field\Save
 */
class Interceptor extends \Amasty\CheckoutCore\Controller\Adminhtml\Field\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\CheckoutCore\Model\Field\Form\SaveHandler $saveHandler)
    {
        $this->___init();
        parent::__construct($context, $saveHandler);
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
