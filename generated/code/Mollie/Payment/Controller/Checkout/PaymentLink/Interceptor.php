<?php
namespace Mollie\Payment\Controller\Checkout\PaymentLink;

/**
 * Interceptor class for @see \Mollie\Payment\Controller\Checkout\PaymentLink
 */
class Interceptor extends \Mollie\Payment\Controller\Checkout\PaymentLink implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\RequestInterface $request, \Magento\Framework\Controller\ResultFactory $resultFactory, \Magento\Framework\Message\ManagerInterface $messageManager, \Mollie\Payment\Service\Magento\PaymentLinkRedirect $paymentLinkRedirect)
    {
        $this->___init();
        parent::__construct($request, $resultFactory, $messageManager, $paymentLinkRedirect);
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
