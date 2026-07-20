<?php
namespace Mollie\Payment\Controller\Checkout\ProcessingWait;

/**
 * Interceptor class for @see \Mollie\Payment\Controller\Checkout\ProcessingWait
 */
class Interceptor extends \Mollie\Payment\Controller\Checkout\ProcessingWait implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Framework\App\RequestInterface $request, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\UrlInterface $url, \Magento\Sales\Api\OrderRepositoryInterface $orderRepository, \Magento\Framework\Encryption\EncryptorInterface $encryptor)
    {
        $this->___init();
        parent::__construct($resultPageFactory, $request, $storeManager, $url, $orderRepository, $encryptor);
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
