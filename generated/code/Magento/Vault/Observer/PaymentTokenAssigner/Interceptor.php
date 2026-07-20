<?php
namespace Magento\Vault\Observer\PaymentTokenAssigner;

/**
 * Interceptor class for @see \Magento\Vault\Observer\PaymentTokenAssigner
 */
class Interceptor extends \Magento\Vault\Observer\PaymentTokenAssigner implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Vault\Api\PaymentTokenManagementInterface $paymentTokenManagement)
    {
        $this->___init();
        parent::__construct($paymentTokenManagement);
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
