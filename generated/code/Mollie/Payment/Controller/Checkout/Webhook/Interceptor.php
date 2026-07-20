<?php
namespace Mollie\Payment\Controller\Checkout\Webhook;

/**
 * Interceptor class for @see \Mollie\Payment\Controller\Checkout\Webhook
 */
class Interceptor extends \Mollie\Payment\Controller\Checkout\Webhook implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Checkout\Model\Session $checkoutSession, \Mollie\Payment\Model\Mollie $mollieModel, \Mollie\Payment\Helper\General $mollieHelper, \Magento\Sales\Api\OrderRepositoryInterface $orderRepository, \Magento\Framework\Encryption\EncryptorInterface $encryptor, \Mollie\Payment\Service\OrderLockService $orderLockService, \Mollie\Payment\Service\Mollie\ProcessTransaction $processTransaction, \Mollie\Payment\Service\Magento\GetOrderIdsByTransactionId $getOrderIdsByTransactionId)
    {
        $this->___init();
        parent::__construct($context, $checkoutSession, $mollieModel, $mollieHelper, $orderRepository, $encryptor, $orderLockService, $processTransaction, $getOrderIdsByTransactionId);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
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
