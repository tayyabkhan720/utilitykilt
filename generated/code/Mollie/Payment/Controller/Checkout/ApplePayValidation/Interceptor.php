<?php
namespace Mollie\Payment\Controller\Checkout\ApplePayValidation;

/**
 * Interceptor class for @see \Mollie\Payment\Controller\Checkout\ApplePayValidation
 */
class Interceptor extends \Mollie\Payment\Controller\Checkout\ApplePayValidation implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Mollie\Payment\Model\Mollie $mollie, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\UrlInterface $url, \Mollie\Payment\Config $config, \Laminas\Uri\Http $http)
    {
        $this->___init();
        parent::__construct($context, $mollie, $storeManager, $url, $config, $http);
    }

    /**
     * {@inheritdoc}
     */
    public function execute(): \Magento\Framework\Controller\Result\Json
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        return $pluginInfo ? $this->___callPlugins('execute', func_get_args(), $pluginInfo) : parent::execute();
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(\Magento\Framework\App\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'dispatch');
        return $pluginInfo ? $this->___callPlugins('dispatch', func_get_args(), $pluginInfo) : parent::dispatch($request);
    }
}
