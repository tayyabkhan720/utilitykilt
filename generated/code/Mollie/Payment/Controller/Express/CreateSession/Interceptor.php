<?php
namespace Mollie\Payment\Controller\Express\CreateSession;

/**
 * Interceptor class for @see \Mollie\Payment\Controller\Express\CreateSession
 */
class Interceptor extends \Mollie\Payment\Controller\Express\CreateSession implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Checkout\Model\Session $checkoutSession, \Magento\Framework\Controller\Result\JsonFactory $jsonFactory, \Magento\Quote\Api\CartRepositoryInterface $cartRepository, \Magento\Framework\App\RequestInterface $request, \Mollie\Payment\Service\Mollie\CreateSession $createSession)
    {
        $this->___init();
        parent::__construct($checkoutSession, $jsonFactory, $cartRepository, $request, $createSession);
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
