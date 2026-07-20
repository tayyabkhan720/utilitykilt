<?php
namespace Mollie\Payment\GraphQL\Resolver\Checkout\PlaceOrderAndReturnRedirectUrl;

/**
 * Interceptor class for @see \Mollie\Payment\GraphQL\Resolver\Checkout\PlaceOrderAndReturnRedirectUrl
 */
class Interceptor extends \Mollie\Payment\GraphQL\Resolver\Checkout\PlaceOrderAndReturnRedirectUrl implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Sales\Api\OrderRepositoryInterface $orderRepository, \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder, \Mollie\Payment\Service\Mollie\StartTransaction $startTransaction)
    {
        $this->___init();
        parent::__construct($orderRepository, $searchCriteriaBuilder, $startTransaction);
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
