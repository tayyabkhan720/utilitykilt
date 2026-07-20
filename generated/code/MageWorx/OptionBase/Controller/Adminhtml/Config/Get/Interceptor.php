<?php
namespace MageWorx\OptionBase\Controller\Adminhtml\Config\Get;

/**
 * Interceptor class for @see \MageWorx\OptionBase\Controller\Adminhtml\Config\Get
 */
class Interceptor extends \MageWorx\OptionBase\Controller\Adminhtml\Config\Get implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \MageWorx\OptionBase\Helper\Data $baseHelper, \MageWorx\OptionBase\Helper\System $systemHelper, \MageWorx\OptionBase\Model\Config\Base $baseConfig, \Magento\Framework\Escaper $escaper, \Magento\Catalog\Api\ProductRepositoryInterface $productRepository, \Magento\Framework\Controller\Result\RawFactory $rawFactory)
    {
        $this->___init();
        parent::__construct($context, $baseHelper, $systemHelper, $baseConfig, $escaper, $productRepository, $rawFactory);
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
