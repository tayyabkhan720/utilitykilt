<?php
namespace Magento\Catalog\Block\Product\View\Options\Type\Select;

/**
 * Interceptor class for @see \Magento\Catalog\Block\Product\View\Options\Type\Select
 */
class Interceptor extends \Magento\Catalog\Block\Product\View\Options\Type\Select implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Magento\Framework\Pricing\Helper\Data $pricingHelper, \Magento\Catalog\Helper\Data $catalogData, array $data = [], ?\Magento\Catalog\Block\Product\View\Options\Type\Select\CheckableFactory $checkableFactory = null, ?\Magento\Catalog\Block\Product\View\Options\Type\Select\MultipleFactory $multipleFactory = null)
    {
        $this->___init();
        parent::__construct($context, $pricingHelper, $catalogData, $data, $checkableFactory, $multipleFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function getValuesHtml(): string
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getValuesHtml');
        return $pluginInfo ? $this->___callPlugins('getValuesHtml', func_get_args(), $pluginInfo) : parent::getValuesHtml();
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getTemplate');
        return $pluginInfo ? $this->___callPlugins('getTemplate', func_get_args(), $pluginInfo) : parent::getTemplate();
    }
}
