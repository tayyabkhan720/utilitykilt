<?php
namespace Magento\Quote\Model\QuoteRepository\LoadHandler;

/**
 * Interceptor class for @see \Magento\Quote\Model\QuoteRepository\LoadHandler
 */
class Interceptor extends \Magento\Quote\Model\QuoteRepository\LoadHandler implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Quote\Model\Quote\ShippingAssignment\ShippingAssignmentProcessor $shippingAssignmentProcessor, \Magento\Quote\Api\Data\CartExtensionFactory $cartExtensionFactory)
    {
        $this->___init();
        parent::__construct($shippingAssignmentProcessor, $cartExtensionFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function load(\Magento\Quote\Api\Data\CartInterface $quote)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'load');
        return $pluginInfo ? $this->___callPlugins('load', func_get_args(), $pluginInfo) : parent::load($quote);
    }
}
