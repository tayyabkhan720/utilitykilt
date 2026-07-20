<?php
namespace MageWorx\OptionDependency\Plugin\CheckoutCartConfigureQuoteItems;

/**
 * Interceptor class for @see \MageWorx\OptionDependency\Plugin\CheckoutCartConfigureQuoteItems
 */
class Interceptor extends \MageWorx\OptionDependency\Plugin\CheckoutCartConfigureQuoteItems implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\MageWorx\OptionBase\Helper\Data $baseHelper, \Magento\Framework\App\RequestInterface $request, \Magento\Quote\Model\Quote\Item $quoteItem, \Magento\Quote\Model\Quote\Item\Option $quoteItemOption, \Magento\Backend\Model\Session\Quote $sessionQuote, \Magento\Catalog\Helper\Product\Composite $productCompositeHelper, \MageWorx\OptionDependency\Model\HiddenDependents $hiddenDependents, \Psr\Log\LoggerInterface $logger, \Magento\Catalog\Helper\Product\View $productViewHelper, \Magento\Framework\App\Action\Context $context, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Checkout\Model\Session $checkoutSession, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator, \Magento\Checkout\Model\Cart $cart)
    {
        $this->___init();
        parent::__construct($baseHelper, $request, $quoteItem, $quoteItemOption, $sessionQuote, $productCompositeHelper, $hiddenDependents, $logger, $productViewHelper, $context, $scopeConfig, $checkoutSession, $storeManager, $formKeyValidator, $cart);
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
