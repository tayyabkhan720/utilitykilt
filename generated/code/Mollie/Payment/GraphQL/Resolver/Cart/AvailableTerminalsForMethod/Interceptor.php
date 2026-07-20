<?php
namespace Mollie\Payment\GraphQL\Resolver\Cart\AvailableTerminalsForMethod;

/**
 * Interceptor class for @see \Mollie\Payment\GraphQL\Resolver\Cart\AvailableTerminalsForMethod
 */
class Interceptor extends \Mollie\Payment\GraphQL\Resolver\Cart\AvailableTerminalsForMethod implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Mollie\Payment\Service\Mollie\AvailableTerminals $availableTerminals)
    {
        $this->___init();
        parent::__construct($availableTerminals);
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
