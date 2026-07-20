<?php
namespace Magento\QuoteGraphQl\Model\CartItem\DataProvider\CustomizableOption;

/**
 * Interceptor class for @see \Magento\QuoteGraphQl\Model\CartItem\DataProvider\CustomizableOption
 */
class Interceptor extends \Magento\QuoteGraphQl\Model\CartItem\DataProvider\CustomizableOption implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\QuoteGraphQl\Model\CartItem\DataProvider\CustomizableOptionValueInterface $customOptionValueDataProvider, ?\Magento\Framework\GraphQl\Query\Uid $uidEncoder = null)
    {
        $this->___init();
        parent::__construct($customOptionValueDataProvider, $uidEncoder);
    }

    /**
     * {@inheritdoc}
     */
    public function getData(\Magento\Quote\Model\Quote\Item $cartItem, int $optionId): array
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getData');
        return $pluginInfo ? $this->___callPlugins('getData', func_get_args(), $pluginInfo) : parent::getData($cartItem, $optionId);
    }
}
