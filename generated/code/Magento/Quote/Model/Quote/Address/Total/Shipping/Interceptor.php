<?php
namespace Magento\Quote\Model\Quote\Address\Total\Shipping;

/**
 * Interceptor class for @see \Magento\Quote\Model\Quote\Address\Total\Shipping
 */
class Interceptor extends \Magento\Quote\Model\Quote\Address\Total\Shipping implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency, \Magento\Quote\Model\Quote\Address\FreeShippingInterface $freeShipping)
    {
        $this->___init();
        parent::__construct($priceCurrency, $freeShipping);
    }

    /**
     * {@inheritdoc}
     */
    public function collect(\Magento\Quote\Model\Quote $quote, \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment, \Magento\Quote\Model\Quote\Address\Total $total)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'collect');
        return $pluginInfo ? $this->___callPlugins('collect', func_get_args(), $pluginInfo) : parent::collect($quote, $shippingAssignment, $total);
    }
}
