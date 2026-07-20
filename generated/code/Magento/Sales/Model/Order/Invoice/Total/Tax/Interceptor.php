<?php
namespace Magento\Sales\Model\Order\Invoice\Total\Tax;

/**
 * Interceptor class for @see \Magento\Sales\Model\Order\Invoice\Total\Tax
 */
class Interceptor extends \Magento\Sales\Model\Order\Invoice\Total\Tax implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(array $data = [])
    {
        $this->___init();
        parent::__construct($data);
    }

    /**
     * {@inheritdoc}
     */
    public function collect(\Magento\Sales\Model\Order\Invoice $invoice)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'collect');
        return $pluginInfo ? $this->___callPlugins('collect', func_get_args(), $pluginInfo) : parent::collect($invoice);
    }
}
