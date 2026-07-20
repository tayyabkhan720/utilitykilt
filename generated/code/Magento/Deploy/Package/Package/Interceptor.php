<?php
namespace Magento\Deploy\Package\Package;

/**
 * Interceptor class for @see \Magento\Deploy\Package\Package
 */
class Interceptor extends \Magento\Deploy\Package\Package implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Deploy\Package\PackagePool $packagePool, \Magento\Framework\View\Asset\PreProcessor\FileNameResolver $fileNameResolver, $area, $theme, $locale, $isVirtual = false, array $preProcessors = [], array $postProcessors = [])
    {
        $this->___init();
        parent::__construct($packagePool, $fileNameResolver, $area, $theme, $locale, $isVirtual, $preProcessors, $postProcessors);
    }

    /**
     * {@inheritdoc}
     */
    public function getFiles()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getFiles');
        return $pluginInfo ? $this->___callPlugins('getFiles', func_get_args(), $pluginInfo) : parent::getFiles();
    }

    /**
     * {@inheritdoc}
     */
    public function getMap()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getMap');
        return $pluginInfo ? $this->___callPlugins('getMap', func_get_args(), $pluginInfo) : parent::getMap();
    }
}
