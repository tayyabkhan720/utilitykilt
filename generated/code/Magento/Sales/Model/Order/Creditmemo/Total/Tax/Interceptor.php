<?php
namespace Magento\Sales\Model\Order\Creditmemo\Total\Tax;

/**
 * Interceptor class for @see \Magento\Sales\Model\Order\Creditmemo\Total\Tax
 */
class Interceptor extends \Magento\Sales\Model\Order\Creditmemo\Total\Tax implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Sales\Model\ResourceModel\Order\Invoice $resourceInvoice, array $data = [], ?\Magento\Tax\Model\Config $taxConfig = null)
    {
        $this->___init();
        parent::__construct($resourceInvoice, $data, $taxConfig);
    }

    /**
     * {@inheritdoc}
     */
    public function collect(\Magento\Sales\Model\Order\Creditmemo $creditmemo)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'collect');
        return $pluginInfo ? $this->___callPlugins('collect', func_get_args(), $pluginInfo) : parent::collect($creditmemo);
    }
}
