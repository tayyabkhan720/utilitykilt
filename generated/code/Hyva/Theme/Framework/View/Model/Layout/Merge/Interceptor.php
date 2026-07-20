<?php
namespace Hyva\Theme\Framework\View\Model\Layout\Merge;

/**
 * Interceptor class for @see \Hyva\Theme\Framework\View\Model\Layout\Merge
 */
class Interceptor extends \Hyva\Theme\Framework\View\Model\Layout\Merge implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\DesignInterface $design, \Magento\Framework\Url\ScopeResolverInterface $scopeResolver, \Magento\Framework\View\File\CollectorInterface $fileSource, \Magento\Framework\View\File\CollectorInterface $pageLayoutFileSource, \Magento\Framework\App\State $appState, \Magento\Framework\Cache\FrontendInterface $cache, \Magento\Framework\View\Model\Layout\Update\Validator $validator, \Psr\Log\LoggerInterface $logger, \Magento\Framework\Filesystem\File\ReadFactory $readFactory, \Magento\Framework\Event\ManagerInterface $eventManager, ?\Magento\Framework\View\Design\ThemeInterface $theme = null, $cacheSuffix = '', ?\Magento\Framework\View\Layout\LayoutCacheKeyInterface $layoutCacheKey = null, ?\Magento\Framework\Serialize\SerializerInterface $serializer = null, ?int $cacheLifetime = null)
    {
        $this->___init();
        parent::__construct($design, $scopeResolver, $fileSource, $pageLayoutFileSource, $appState, $cache, $validator, $logger, $readFactory, $eventManager, $theme, $cacheSuffix, $layoutCacheKey, $serializer, $cacheLifetime);
    }

    /**
     * {@inheritdoc}
     */
    public function validateUpdate($handle, $updateXml)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'validateUpdate');
        return $pluginInfo ? $this->___callPlugins('validateUpdate', func_get_args(), $pluginInfo) : parent::validateUpdate($handle, $updateXml);
    }

    /**
     * {@inheritdoc}
     */
    public function getDbUpdateString($handle)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getDbUpdateString');
        return $pluginInfo ? $this->___callPlugins('getDbUpdateString', func_get_args(), $pluginInfo) : parent::getDbUpdateString($handle);
    }
}
