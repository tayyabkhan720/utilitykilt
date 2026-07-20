<?php
namespace Magento\PaymentServicesPaypal\Observer\AddCheckoutComponents;

/**
 * Interceptor class for @see \Magento\PaymentServicesPaypal\Observer\AddCheckoutComponents
 */
class Interceptor extends \Magento\PaymentServicesPaypal\Observer\AddCheckoutComponents implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\PaymentServicesBase\Model\Config $paymentConfig, \Magento\Checkout\Model\Session $session, array $blocks = [])
    {
        $this->___init();
        parent::__construct($paymentConfig, $session, $blocks);
    }

    /**
     * {@inheritdoc}
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        return $pluginInfo ? $this->___callPlugins('execute', func_get_args(), $pluginInfo) : parent::execute($observer);
    }
}
