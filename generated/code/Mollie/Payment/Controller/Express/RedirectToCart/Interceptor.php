<?php
namespace Mollie\Payment\Controller\Express\RedirectToCart;

/**
 * Interceptor class for @see \Mollie\Payment\Controller\Express\RedirectToCart
 */
class Interceptor extends \Mollie\Payment\Controller\Express\RedirectToCart implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\RequestInterface $request, \Magento\Framework\Message\ManagerInterface $messageManager, \Magento\Quote\Api\CartRepositoryInterface $cartRepository, \Magento\Framework\Controller\ResultFactory $resultFactory, \Mollie\Payment\Config $config, \Mollie\Payment\Api\PaymentTokenRepositoryInterface $paymentTokenRepository)
    {
        $this->___init();
        parent::__construct($request, $messageManager, $cartRepository, $resultFactory, $config, $paymentTokenRepository);
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
