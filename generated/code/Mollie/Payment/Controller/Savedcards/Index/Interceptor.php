<?php
namespace Mollie\Payment\Controller\Savedcards\Index;

/**
 * Interceptor class for @see \Mollie\Payment\Controller\Savedcards\Index
 */
class Interceptor extends \Mollie\Payment\Controller\Savedcards\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Controller\ResultFactory $resultFactory, \Mollie\Payment\Config $config)
    {
        $this->___init();
        parent::__construct($resultFactory, $config);
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
