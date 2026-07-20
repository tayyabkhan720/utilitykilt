<?php
namespace Amasty\Base\Model\ModuleInfoProvider;

/**
 * Interceptor class for @see \Amasty\Base\Model\ModuleInfoProvider
 */
class Interceptor extends \Amasty\Base\Model\ModuleInfoProvider implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Module\Dir\Reader $moduleReader, \Magento\Framework\Filesystem\Driver\File $filesystem, \Amasty\Base\Model\Serializer $serializer)
    {
        $this->___init();
        parent::__construct($moduleReader, $filesystem, $serializer);
    }

    /**
     * {@inheritdoc}
     */
    public function getRestrictedModules(): array
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getRestrictedModules');
        return $pluginInfo ? $this->___callPlugins('getRestrictedModules', func_get_args(), $pluginInfo) : parent::getRestrictedModules();
    }
}
