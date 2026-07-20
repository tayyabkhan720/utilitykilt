<?php
namespace Mollie\Payment\GraphQL\Resolver\Cart\ResetCart;

/**
 * Interceptor class for @see \Mollie\Payment\GraphQL\Resolver\Cart\ResetCart
 */
class Interceptor extends \Mollie\Payment\GraphQL\Resolver\Cart\ResetCart implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Quote\Model\MaskedQuoteIdToQuoteIdInterface $maskedQuoteIdToQuoteId, \Magento\Quote\Api\CartRepositoryInterface $cartRepository)
    {
        $this->___init();
        parent::__construct($maskedQuoteIdToQuoteId, $cartRepository);
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(\Magento\Framework\GraphQl\Config\Element\Field $field, $context, \Magento\Framework\GraphQl\Schema\Type\ResolveInfo $info, ?array $value = null, ?array $args = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'resolve');
        return $pluginInfo ? $this->___callPlugins('resolve', func_get_args(), $pluginInfo) : parent::resolve($field, $context, $info, $value, $args);
    }
}
