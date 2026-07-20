<?php
namespace Mollie\Payment\Controller\Express\Webhook;

/**
 * Interceptor class for @see \Mollie\Payment\Controller\Express\Webhook
 */
class Interceptor extends \Mollie\Payment\Controller\Express\Webhook implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\RequestInterface $request, \Magento\Framework\Controller\Result\Raw $response, \Magento\Framework\Api\SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory, \Magento\Quote\Api\CartRepositoryInterface $cartRepository, \Magento\Sales\Api\OrderRepositoryInterface $orderRepository, \Mollie\Payment\Config $config, \Mollie\Payment\Service\Mollie\Wrapper\GetExpressPayment $getExpressPayment, \Mollie\Payment\Model\Mollie $mollieModel, \Mollie\Payment\Service\LockService $lockService, \Mollie\Payment\Service\Mollie\Order\ConvertComponentsPaymentToOrder $convertComponentPaymentToOrder)
    {
        $this->___init();
        parent::__construct($request, $response, $searchCriteriaBuilderFactory, $cartRepository, $orderRepository, $config, $getExpressPayment, $mollieModel, $lockService, $convertComponentPaymentToOrder);
    }

    /**
     * {@inheritdoc}
     */
    public function execute(): \Magento\Framework\Controller\ResultInterface
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        return $pluginInfo ? $this->___callPlugins('execute', func_get_args(), $pluginInfo) : parent::execute();
    }
}
