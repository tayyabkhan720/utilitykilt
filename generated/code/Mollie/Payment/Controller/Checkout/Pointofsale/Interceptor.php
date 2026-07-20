<?php
namespace Mollie\Payment\Controller\Checkout\Pointofsale;

/**
 * Interceptor class for @see \Mollie\Payment\Controller\Checkout\Pointofsale
 */
class Interceptor extends \Mollie\Payment\Controller\Checkout\Pointofsale implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Framework\App\RequestInterface $request, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\UrlInterface $url, \Magento\Sales\Api\OrderRepositoryInterface $orderRepository, \Magento\Framework\Encryption\EncryptorInterface $encryptor, \Mollie\Payment\Api\PaymentTokenRepositoryInterface $paymentTokenRepository, \Mollie\Payment\Service\PaymentToken\Generate $generatePaymentToken)
    {
        $this->___init();
        parent::__construct($resultPageFactory, $request, $storeManager, $url, $orderRepository, $encryptor, $paymentTokenRepository, $generatePaymentToken);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        return $pluginInfo ? $this->___callPlugins('execute', func_get_args(), $pluginInfo) : parent::execute();
    }
}
