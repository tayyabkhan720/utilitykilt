<?php
namespace Mollie\Payment\GraphQL\Resolver\General\MollieStoreConfig;

/**
 * Interceptor class for @see \Mollie\Payment\GraphQL\Resolver\General\MollieStoreConfig
 */
class Interceptor extends \Mollie\Payment\GraphQL\Resolver\General\MollieStoreConfig implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Mollie\Payment\Config $config)
    {
        $this->___init();
        parent::__construct($config);
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
