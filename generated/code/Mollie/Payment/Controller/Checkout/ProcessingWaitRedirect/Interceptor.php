<?php
namespace Mollie\Payment\Controller\Checkout\ProcessingWaitRedirect;

/**
 * Interceptor class for @see \Mollie\Payment\Controller\Checkout\ProcessingWaitRedirect
 */
class Interceptor extends \Mollie\Payment\Controller\Checkout\ProcessingWaitRedirect implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\RequestInterface $request, \Magento\Framework\App\ResponseInterface $response, \Magento\Sales\Api\OrderRepositoryInterface $orderRepository, \Magento\Framework\Encryption\EncryptorInterface $encryptor, \Mollie\Payment\Model\Mollie $mollieModel, \Mollie\Payment\Service\Mollie\GetMollieStatusResultFactory $getMollieStatusResultFactory, \Mollie\Payment\Service\Mollie\Order\SuccessPageRedirect $successPageRedirect, \Magento\Checkout\Model\Session $checkoutSession, \Mollie\Payment\Service\Mollie\Order\AddResultMessage $addResultMessage, \Mollie\Payment\Service\Order\RedirectOnError $redirectOnError)
    {
        $this->___init();
        parent::__construct($request, $response, $orderRepository, $encryptor, $mollieModel, $getMollieStatusResultFactory, $successPageRedirect, $checkoutSession, $addResultMessage, $redirectOnError);
    }

    /**
     * {@inheritdoc}
     */
    public function execute(): \Magento\Framework\App\ResponseInterface
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        return $pluginInfo ? $this->___callPlugins('execute', func_get_args(), $pluginInfo) : parent::execute();
    }
}
