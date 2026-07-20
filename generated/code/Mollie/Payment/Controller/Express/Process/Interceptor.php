<?php
namespace Mollie\Payment\Controller\Express\Process;

/**
 * Interceptor class for @see \Mollie\Payment\Controller\Express\Process
 */
class Interceptor extends \Mollie\Payment\Controller\Express\Process implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\RequestInterface $request, \Magento\Quote\Api\CartRepositoryInterface $cartRepository, \Mollie\Payment\Api\PaymentTokenRepositoryInterface $paymentTokenRepository, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Store\Model\StoreManagerInterface $storeManager, \Mollie\Payment\Service\Mollie\MollieApiClient $mollieApiClient, \Magento\Framework\Controller\ResultFactory $resultFactory, \Magento\Framework\Message\ManagerInterface $messageManager, \Magento\Framework\UrlInterface $urlBuilder)
    {
        $this->___init();
        parent::__construct($request, $cartRepository, $paymentTokenRepository, $resultPageFactory, $storeManager, $mollieApiClient, $resultFactory, $messageManager, $urlBuilder);
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
