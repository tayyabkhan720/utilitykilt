<?php
namespace Magento\Framework\Event\Config;

/**
 * Interceptor class for @see \Magento\Framework\Event\Config
 */
class Interceptor extends \Magento\Framework\Event\Config implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Event\Config\Data $dataContainer)
    {
        $this->___init();
        parent::__construct($dataContainer);
    }

    /**
     * {@inheritdoc}
     */
    public function getObservers($eventName)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getObservers');
        return $pluginInfo ? $this->___callPlugins('getObservers', func_get_args(), $pluginInfo) : parent::getObservers($eventName);
    }
}
