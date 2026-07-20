<?php
namespace Magento\PageBuilder\Plugin\Filter\TemplatePlugin;

/**
 * Interceptor class for @see \Magento\PageBuilder\Plugin\Filter\TemplatePlugin
 */
class Interceptor extends \Magento\PageBuilder\Plugin\Filter\TemplatePlugin implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\PageBuilder\Model\Filter\Template $templateFilter)
    {
        $this->___init();
        parent::__construct($templateFilter);
    }

    /**
     * {@inheritdoc}
     */
    public function afterFilter(\Magento\Framework\Filter\Template $subject, $result)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'afterFilter');
        return $pluginInfo ? $this->___callPlugins('afterFilter', func_get_args(), $pluginInfo) : parent::afterFilter($subject, $result);
    }
}
