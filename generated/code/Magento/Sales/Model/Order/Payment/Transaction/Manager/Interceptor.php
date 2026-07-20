<?php
namespace Magento\Sales\Model\Order\Payment\Transaction\Manager;

/**
 * Interceptor class for @see \Magento\Sales\Model\Order\Payment\Transaction\Manager
 */
class Interceptor extends \Magento\Sales\Model\Order\Payment\Transaction\Manager implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Sales\Api\TransactionRepositoryInterface $transactionRepository)
    {
        $this->___init();
        parent::__construct($transactionRepository);
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthorizationTransaction($parentTransactionId, $paymentId, $orderId)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getAuthorizationTransaction');
        return $pluginInfo ? $this->___callPlugins('getAuthorizationTransaction', func_get_args(), $pluginInfo) : parent::getAuthorizationTransaction($parentTransactionId, $paymentId, $orderId);
    }
}
