<?php
namespace Magento\Theme\Controller\Result\JsFooterPlugin;

/**
 * Interceptor class for @see \Magento\Theme\Controller\Result\JsFooterPlugin
 */
class Interceptor extends \Magento\Theme\Controller\Result\JsFooterPlugin implements \Magento\Framework\Interception\InterceptorInterface
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
    public function afterRenderResult(\Magento\Framework\View\Result\Layout $subject, \Magento\Framework\View\Result\Layout $result, \Magento\Framework\App\ResponseInterface $httpResponse)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'afterRenderResult');
        return $pluginInfo ? $this->___callPlugins('afterRenderResult', func_get_args(), $pluginInfo) : parent::afterRenderResult($subject, $result, $httpResponse);
    }
}
