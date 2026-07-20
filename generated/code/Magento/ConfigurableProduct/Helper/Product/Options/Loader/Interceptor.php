<?php
namespace Magento\ConfigurableProduct\Helper\Product\Options\Loader;

/**
 * Interceptor class for @see \Magento\ConfigurableProduct\Helper\Product\Options\Loader
 */
class Interceptor extends \Magento\ConfigurableProduct\Helper\Product\Options\Loader implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\ConfigurableProduct\Api\Data\OptionValueInterfaceFactory $optionValueFactory, \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface $extensionAttributesJoinProcessor)
    {
        $this->___init();
        parent::__construct($optionValueFactory, $extensionAttributesJoinProcessor);
    }

    /**
     * {@inheritdoc}
     */
    public function load(\Magento\Catalog\Api\Data\ProductInterface $product)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'load');
        return $pluginInfo ? $this->___callPlugins('load', func_get_args(), $pluginInfo) : parent::load($product);
    }
}
