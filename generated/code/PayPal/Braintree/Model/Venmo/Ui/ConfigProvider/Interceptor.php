<?php
namespace PayPal\Braintree\Model\Venmo\Ui\ConfigProvider;

/**
 * Interceptor class for @see \PayPal\Braintree\Model\Venmo\Ui\ConfigProvider
 */
class Interceptor extends \PayPal\Braintree\Model\Venmo\Ui\ConfigProvider implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\PayPal\Braintree\Model\Adapter\BraintreeAdapter $adapter, \Magento\Framework\View\Asset\Repository $assetRepo, \PayPal\Braintree\Gateway\Config\Config $braintreeConfig, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Framework\View\Asset\Source $assetSource)
    {
        $this->___init();
        parent::__construct($adapter, $assetRepo, $braintreeConfig, $scopeConfig, $assetSource);
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
