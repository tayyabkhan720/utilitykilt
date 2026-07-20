<?php
namespace Magento\ImportExport\Model\Export\Config;

/**
 * Interceptor class for @see \Magento\ImportExport\Model\Export\Config
 */
class Interceptor extends \Magento\ImportExport\Model\Export\Config implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\ImportExport\Model\Export\Config\Reader $reader, \Magento\Framework\Config\CacheInterface $cache, $cacheId = 'export_config_cache', ?\Magento\Framework\Serialize\SerializerInterface $serializer = null)
    {
        $this->___init();
        parent::__construct($reader, $cache, $cacheId, $serializer);
    }

    /**
     * {@inheritdoc}
     */
    public function getEntities()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getEntities');
        return $pluginInfo ? $this->___callPlugins('getEntities', func_get_args(), $pluginInfo) : parent::getEntities();
    }
}
