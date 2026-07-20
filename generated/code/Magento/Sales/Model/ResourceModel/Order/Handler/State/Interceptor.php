<?php
namespace Magento\Sales\Model\ResourceModel\Order\Handler\State;

/**
 * Interceptor class for @see \Magento\Sales\Model\ResourceModel\Order\Handler\State
 */
class Interceptor extends \Magento\Sales\Model\ResourceModel\Order\Handler\State implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct()
    {
        $this->___init();
    }

    /**
     * {@inheritdoc}
     */
    public function check(\Magento\Sales\Model\Order $order)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'check');
        return $pluginInfo ? $this->___callPlugins('check', func_get_args(), $pluginInfo) : parent::check($order);
    }
}
