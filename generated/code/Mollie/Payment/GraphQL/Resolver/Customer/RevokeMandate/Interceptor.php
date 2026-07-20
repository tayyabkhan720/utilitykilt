<?php
namespace Mollie\Payment\GraphQL\Resolver\Customer\RevokeMandate;

/**
 * Interceptor class for @see \Mollie\Payment\GraphQL\Resolver\Customer\RevokeMandate
 */
class Interceptor extends \Mollie\Payment\GraphQL\Resolver\Customer\RevokeMandate implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Mollie\Payment\Service\Mollie\RevokeMandate $revokeMandate, \Mollie\Payment\Config $config)
    {
        $this->___init();
        parent::__construct($revokeMandate, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(\Magento\Framework\GraphQl\Config\Element\Field $field, $context, \Magento\Framework\GraphQl\Schema\Type\ResolveInfo $info, ?array $value = null, ?array $args = null): array
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'resolve');
        return $pluginInfo ? $this->___callPlugins('resolve', func_get_args(), $pluginInfo) : parent::resolve($field, $context, $info, $value, $args);
    }
}
