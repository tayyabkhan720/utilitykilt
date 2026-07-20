<?php
namespace MageWorx\OptionImportExport\Plugin\ExtendImportEntitiesConfig;

/**
 * Interceptor class for @see \MageWorx\OptionImportExport\Plugin\ExtendImportEntitiesConfig
 */
class Interceptor extends \MageWorx\OptionImportExport\Plugin\ExtendImportEntitiesConfig implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\ImportExport\Model\Import\Config\Reader $reader, \Magento\Framework\Config\CacheInterface $cache, $cacheId = 'import_config_cache', ?\Magento\Framework\Serialize\SerializerInterface $serializer = null)
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
