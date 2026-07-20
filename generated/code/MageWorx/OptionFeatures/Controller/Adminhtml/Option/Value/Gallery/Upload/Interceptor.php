<?php
namespace MageWorx\OptionFeatures\Controller\Adminhtml\Option\Value\Gallery\Upload;

/**
 * Interceptor class for @see \MageWorx\OptionFeatures\Controller\Adminhtml\Option\Value\Gallery\Upload
 */
class Interceptor extends \MageWorx\OptionFeatures\Controller\Adminhtml\Option\Value\Gallery\Upload implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Controller\Result\RawFactory $resultRawFactory, \MageWorx\OptionFeatures\Helper\Image $imageHelper, \Magento\Framework\Serialize\Serializer\Json $serializer)
    {
        $this->___init();
        parent::__construct($context, $resultRawFactory, $imageHelper, $serializer);
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
