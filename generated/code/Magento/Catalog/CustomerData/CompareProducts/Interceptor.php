<?php
namespace Magento\Catalog\CustomerData\CompareProducts;

/**
 * Interceptor class for @see \Magento\Catalog\CustomerData\CompareProducts
 */
class Interceptor extends \Magento\Catalog\CustomerData\CompareProducts implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Helper\Product\Compare $helper, \Magento\Catalog\Model\Product\Url $productUrl, \Magento\Catalog\Helper\Output $outputHelper, ?\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig = null, ?\Magento\Store\Model\StoreManagerInterface $storeManager = null, ?\Magento\Framework\UrlInterface $urlBuilder = null)
    {
        $this->___init();
        parent::__construct($helper, $productUrl, $outputHelper, $scopeConfig, $storeManager, $urlBuilder);
    }

    /**
     * {@inheritdoc}
     */
    public function getSectionData()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSectionData');
        return $pluginInfo ? $this->___callPlugins('getSectionData', func_get_args(), $pluginInfo) : parent::getSectionData();
    }
}
