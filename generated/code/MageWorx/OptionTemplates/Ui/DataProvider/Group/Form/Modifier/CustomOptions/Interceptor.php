<?php
namespace MageWorx\OptionTemplates\Ui\DataProvider\Group\Form\Modifier\CustomOptions;

/**
 * Interceptor class for @see \MageWorx\OptionTemplates\Ui\DataProvider\Group\Form\Modifier\CustomOptions
 */
class Interceptor extends \MageWorx\OptionTemplates\Ui\DataProvider\Group\Form\Modifier\CustomOptions implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Model\Locator\LocatorInterface $locator, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Catalog\Model\ProductOptions\ConfigInterface $productOptionsConfig, \Magento\Catalog\Model\Config\Source\Product\Options\Price $productOptionsPrice, \Magento\Framework\UrlInterface $urlBuilder, \Magento\Framework\Stdlib\ArrayManager $arrayManager)
    {
        $this->___init();
        parent::__construct($locator, $storeManager, $productOptionsConfig, $productOptionsPrice, $urlBuilder, $arrayManager);
    }

    /**
     * {@inheritdoc}
     */
    public function modifyMeta(array $meta)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'modifyMeta');
        return $pluginInfo ? $this->___callPlugins('modifyMeta', func_get_args(), $pluginInfo) : parent::modifyMeta($meta);
    }
}
