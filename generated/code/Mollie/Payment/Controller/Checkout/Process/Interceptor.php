<?php
namespace Mollie\Payment\Controller\Checkout\Process;

/**
 * Interceptor class for @see \Mollie\Payment\Controller\Checkout\Process
 */
class Interceptor extends \Mollie\Payment\Controller\Checkout\Process implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Checkout\Model\Session $checkoutSession, \Magento\Payment\Helper\Data $paymentHelper, \Mollie\Payment\Model\Mollie $mollieModel, \Mollie\Payment\Helper\General $mollieHelper, \Magento\Sales\Api\OrderRepositoryInterface $orderRepository, \Mollie\Payment\Service\Order\RedirectOnError $redirectOnError, \Mollie\Payment\Service\Mollie\ValidateProcessRequest $validateProcessRequest, \Mollie\Payment\Service\Mollie\ProcessTransaction $processTransaction, \Mollie\Payment\Service\Mollie\Order\SuccessPageRedirect $successPageRedirect, \Mollie\Payment\Service\Mollie\Order\AddResultMessage $addResultMessage, \Magento\Framework\Encryption\EncryptorInterface $encryptor)
    {
        $this->___init();
        parent::__construct($context, $checkoutSession, $paymentHelper, $mollieModel, $mollieHelper, $orderRepository, $redirectOnError, $validateProcessRequest, $processTransaction, $successPageRedirect, $addResultMessage, $encryptor);
    }

    /**
     * {@inheritdoc}
     */
    public function execute(): \Magento\Framework\App\ResponseInterface
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
