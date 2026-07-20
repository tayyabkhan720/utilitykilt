<?php
namespace Magento\Framework\View\Asset\PreProcessor\Minify;

/**
 * Interceptor class for @see \Magento\Framework\View\Asset\PreProcessor\Minify
 */
class Interceptor extends \Magento\Framework\View\Asset\PreProcessor\Minify implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Code\Minifier\AdapterInterface $adapter, \Magento\Framework\View\Asset\Minification $minification, \Magento\Framework\View\Asset\PreProcessor\MinificationConfigProvider $minificationConfig)
    {
        $this->___init();
        parent::__construct($adapter, $minification, $minificationConfig);
    }

    /**
     * {@inheritdoc}
     */
    public function process(\Magento\Framework\View\Asset\PreProcessor\Chain $chain)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'process');
        return $pluginInfo ? $this->___callPlugins('process', func_get_args(), $pluginInfo) : parent::process($chain);
    }
}
