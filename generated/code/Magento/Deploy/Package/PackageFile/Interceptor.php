<?php
namespace Magento\Deploy\Package\PackageFile;

/**
 * Interceptor class for @see \Magento\Deploy\Package\PackageFile
 */
class Interceptor extends \Magento\Deploy\Package\PackageFile implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct($fileName, $sourcePath = null, $area = null, $theme = null, $locale = null, $module = null)
    {
        $this->___init();
        parent::__construct($fileName, $sourcePath, $area, $theme, $locale, $module);
    }

    /**
     * {@inheritdoc}
     */
    public function setPackage(\Magento\Deploy\Package\Package $package)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setPackage');
        return $pluginInfo ? $this->___callPlugins('setPackage', func_get_args(), $pluginInfo) : parent::setPackage($package);
    }
}
