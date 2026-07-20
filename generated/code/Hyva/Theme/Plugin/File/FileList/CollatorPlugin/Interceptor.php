<?php
namespace Hyva\Theme\Plugin\File\FileList\CollatorPlugin;

/**
 * Interceptor class for @see \Hyva\Theme\Plugin\File\FileList\CollatorPlugin
 */
class Interceptor extends \Hyva\Theme\Plugin\File\FileList\CollatorPlugin implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct()
    {
        $this->___init();
    }

    /**
     * {@inheritdoc}
     */
    public function collate($files, $filesOrigin)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'collate');
        return $pluginInfo ? $this->___callPlugins('collate', func_get_args(), $pluginInfo) : parent::collate($files, $filesOrigin);
    }
}
