<?php
namespace StripeIntegration\Payments\Model\Method\BankTransfers;

/**
 * Interceptor class for @see \StripeIntegration\Payments\Model\Method\BankTransfers
 */
class Interceptor extends \StripeIntegration\Payments\Model\Method\BankTransfers implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\StripeIntegration\Payments\Model\Config $config, \StripeIntegration\Payments\Helper\Generic $helper, \StripeIntegration\Payments\Helper\BankTransfers $bankTransfersHelper, \StripeIntegration\Payments\Helper\AreaCode $areaCodeHelper, \Magento\Framework\Event\ManagerInterface $eventManager, \Magento\Payment\Gateway\Config\ValueHandlerPoolInterface $valueHandlerPool, \Magento\Payment\Gateway\Data\PaymentDataObjectFactory $paymentDataObjectFactory, $code, $formBlockType, $infoBlockType, ?\Magento\Payment\Gateway\Command\CommandPoolInterface $commandPool = null, ?\Magento\Payment\Gateway\Validator\ValidatorPoolInterface $validatorPool = null, ?\Magento\Payment\Gateway\Command\CommandManagerInterface $commandExecutor = null, ?\Psr\Log\LoggerInterface $logger = null)
    {
        $this->___init();
        parent::__construct($config, $helper, $bankTransfersHelper, $areaCodeHelper, $eventManager, $valueHandlerPool, $paymentDataObjectFactory, $code, $formBlockType, $infoBlockType, $commandPool, $validatorPool, $commandExecutor, $logger);
    }

    /**
     * {@inheritdoc}
     */
    public function isActive($storeId = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isActive');
        return $pluginInfo ? $this->___callPlugins('isActive', func_get_args(), $pluginInfo) : parent::isActive($storeId);
    }

    /**
     * {@inheritdoc}
     */
    public function canCapture()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'canCapture');
        return $pluginInfo ? $this->___callPlugins('canCapture', func_get_args(), $pluginInfo) : parent::canCapture();
    }

    /**
     * {@inheritdoc}
     */
    public function canReviewPayment()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'canReviewPayment');
        return $pluginInfo ? $this->___callPlugins('canReviewPayment', func_get_args(), $pluginInfo) : parent::canReviewPayment();
    }
}
