<?php
namespace PayPal\Braintree\Model\Ui\ConfigProvider;

/**
 * Interceptor class for @see \PayPal\Braintree\Model\Ui\ConfigProvider
 */
class Interceptor extends \PayPal\Braintree\Model\Ui\ConfigProvider implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\PayPal\Braintree\Gateway\Config\Config $config, \PayPal\Braintree\Gateway\Config\PayPal\Config $payPalConfig, \PayPal\Braintree\Model\Adapter\BraintreeAdapter $adapter, \Magento\Payment\Model\CcConfig $ccConfig, \Magento\Framework\View\Asset\Source $assetSource)
    {
        $this->___init();
        parent::__construct($config, $payPalConfig, $adapter, $ccConfig, $assetSource);
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
