<?php
namespace PayPal\Braintree\Model\GooglePay\Ui\ConfigProvider;

/**
 * Interceptor class for @see \PayPal\Braintree\Model\GooglePay\Ui\ConfigProvider
 */
class Interceptor extends \PayPal\Braintree\Model\GooglePay\Ui\ConfigProvider implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\PayPal\Braintree\Model\GooglePay\Config $config, \PayPal\Braintree\Model\Adapter\BraintreeAdapter $adapter, \Magento\Framework\View\Asset\Repository $assetRepo, \PayPal\Braintree\Gateway\Config\Config $braintreeConfig, \PayPal\Braintree\Gateway\Config\GooglePay\Config $googlePayConfig, \Magento\Tax\Helper\Data $taxHelper)
    {
        $this->___init();
        parent::__construct($config, $adapter, $assetRepo, $braintreeConfig, $googlePayConfig, $taxHelper);
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
