<?php
namespace PayPal\Braintree\Model\Ach\Ui\ConfigProvider;

/**
 * Interceptor class for @see \PayPal\Braintree\Model\Ach\Ui\ConfigProvider
 */
class Interceptor extends \PayPal\Braintree\Model\Ach\Ui\ConfigProvider implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\PayPal\Braintree\Model\Adapter\BraintreeAdapter $adapter, \PayPal\Braintree\Gateway\Config\Config $braintreeConfig, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \PayPal\Braintree\Gateway\Config\Ach\Config $config)
    {
        $this->___init();
        parent::__construct($adapter, $braintreeConfig, $scopeConfig, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig(): array
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getConfig');
        return $pluginInfo ? $this->___callPlugins('getConfig', func_get_args(), $pluginInfo) : parent::getConfig();
    }
}
