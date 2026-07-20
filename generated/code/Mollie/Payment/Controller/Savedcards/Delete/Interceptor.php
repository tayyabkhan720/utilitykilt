<?php
namespace Mollie\Payment\Controller\Savedcards\Delete;

/**
 * Interceptor class for @see \Mollie\Payment\Controller\Savedcards\Delete
 */
class Interceptor extends \Mollie\Payment\Controller\Savedcards\Delete implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\RequestInterface $request, \Magento\Framework\Controller\ResultFactory $resultFactory, \Magento\Framework\Message\ManagerInterface $messageManager, \Magento\Framework\Data\Form\FormKey\Validator $csrfValidator, \Mollie\Payment\Service\Mollie\RevokeMandate $revokeMandate, \Mollie\Payment\Config $config, \Mollie\Payment\Logger\MollieLogger $logger)
    {
        $this->___init();
        parent::__construct($request, $resultFactory, $messageManager, $csrfValidator, $revokeMandate, $config, $logger);
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
