<?php
namespace Magento\Framework\View\Asset\Config;

/**
 * Interceptor class for @see \Magento\Framework\View\Asset\Config
 */
class Interceptor extends \Magento\Framework\View\Asset\Config implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig)
    {
        $this->___init();
        parent::__construct($scopeConfig);
    }

    /**
     * {@inheritdoc}
     */
    public function isBundlingJsFiles()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isBundlingJsFiles');
        return $pluginInfo ? $this->___callPlugins('isBundlingJsFiles', func_get_args(), $pluginInfo) : parent::isBundlingJsFiles();
    }
}
