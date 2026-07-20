<?php
namespace Magento\PaymentServicesPaypal\Controller\SmartButtons\SDKBased\PlaceOrder;

/**
 * Interceptor class for @see \Magento\PaymentServicesPaypal\Controller\SmartButtons\SDKBased\PlaceOrder
 */
class Interceptor extends \Magento\PaymentServicesPaypal\Controller\SmartButtons\SDKBased\PlaceOrder implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\RequestInterface $request, \Magento\Framework\Controller\ResultFactory $resultFactory, \Magento\PaymentServicesPaypal\Model\SmartButtons\Checkout $checkout, \Magento\Framework\UrlInterface $url, \Magento\PaymentServicesPaypal\Model\CancellationService $cancellationService, \Magento\Framework\Message\ManagerInterface $messageManager)
    {
        $this->___init();
        parent::__construct($request, $resultFactory, $checkout, $url, $cancellationService, $messageManager);
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
