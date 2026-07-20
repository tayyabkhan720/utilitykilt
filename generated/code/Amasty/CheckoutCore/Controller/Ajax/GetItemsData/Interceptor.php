<?php
namespace Amasty\CheckoutCore\Controller\Ajax\GetItemsData;

/**
 * Interceptor class for @see \Amasty\CheckoutCore\Controller\Ajax\GetItemsData
 */
class Interceptor extends \Amasty\CheckoutCore\Controller\Ajax\GetItemsData implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Checkout\Model\Session $checkoutSession, \Amasty\CheckoutCore\Helper\Item $itemHelper, \Magento\Catalog\Helper\Image $imageHelper)
    {
        $this->___init();
        parent::__construct($context, $checkoutSession, $itemHelper, $imageHelper);
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
