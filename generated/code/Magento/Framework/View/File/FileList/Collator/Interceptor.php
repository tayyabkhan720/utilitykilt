<?php
namespace Magento\Framework\View\File\FileList\Collator;

/**
 * Interceptor class for @see \Magento\Framework\View\File\FileList\Collator
 */
class Interceptor extends \Magento\Framework\View\File\FileList\Collator implements \Magento\Framework\Interception\InterceptorInterface
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
