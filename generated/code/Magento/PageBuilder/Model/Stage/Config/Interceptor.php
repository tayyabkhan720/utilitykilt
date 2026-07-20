<?php
namespace Magento\PageBuilder\Model\Stage\Config;

/**
 * Interceptor class for @see \Magento\PageBuilder\Model\Stage\Config
 */
class Interceptor extends \Magento\PageBuilder\Model\Stage\Config implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\PageBuilder\Model\ConfigInterface $config, \Magento\PageBuilder\Model\Stage\Config\UiComponentConfig $uiComponentConfig, \Magento\Framework\UrlInterface $urlBuilder, \Magento\Framework\Url $frontendUrlBuilder, \Magento\PageBuilder\Model\Config\ContentType\AdditionalData\Parser $additionalDataParser, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Ui\Block\Wysiwyg\ActiveEditor $activeEditor, \Magento\PageBuilder\Model\Wysiwyg\InlineEditingSupportedAdapterList $inlineEditingChecker, \Magento\PageBuilder\Model\WidgetInitializerConfig $widgetInitializerConfig, array $rootContainerConfig = [], array $data = [], ?\Magento\Widget\Model\Widget\Config $widgetConfig = null, ?\Magento\Variable\Model\Variable\Config $variableConfig = null, ?\Magento\Framework\AuthorizationInterface $authorization = null, ?\Magento\Framework\Cache\FrontendInterface $cache = null, ?\Magento\Framework\Serialize\Serializer\Json $serializer = null, ?\Magento\PageBuilder\Model\Session\RandomKey $sessionRandomKey = null)
    {
        $this->___init();
        parent::__construct($config, $uiComponentConfig, $urlBuilder, $frontendUrlBuilder, $additionalDataParser, $scopeConfig, $activeEditor, $inlineEditingChecker, $widgetInitializerConfig, $rootContainerConfig, $data, $widgetConfig, $variableConfig, $authorization, $cache, $serializer, $sessionRandomKey);
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getConfig');
        return $pluginInfo ? $this->___callPlugins('getConfig', func_get_args(), $pluginInfo) : parent::getConfig();
    }
}
