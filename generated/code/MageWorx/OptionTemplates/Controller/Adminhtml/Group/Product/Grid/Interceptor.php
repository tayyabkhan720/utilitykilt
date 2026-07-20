<?php
namespace MageWorx\OptionTemplates\Controller\Adminhtml\Group\Product\Grid;

/**
 * Interceptor class for @see \MageWorx\OptionTemplates\Controller\Adminhtml\Group\Product\Grid
 */
class Interceptor extends \MageWorx\OptionTemplates\Controller\Adminhtml\Group\Product\Grid implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Controller\Result\RawFactory $resultRawFactory, \Magento\Framework\View\LayoutFactory $layoutFactory, \Magento\Catalog\Controller\Adminhtml\Product\Builder $productBuilder)
    {
        $this->___init();
        parent::__construct($context, $resultRawFactory, $layoutFactory, $productBuilder);
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
