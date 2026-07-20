<?php
namespace Magento\Tax\Helper\Data;

/**
 * Interceptor class for @see \Magento\Tax\Helper\Data
 */
class Interceptor extends \Magento\Tax\Helper\Data implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Helper\Context $context, \Magento\Framework\Json\Helper\Data $jsonHelper, \Magento\Tax\Model\Config $taxConfig, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\Locale\FormatInterface $localeFormat, \Magento\Tax\Model\ResourceModel\Sales\Order\Tax\CollectionFactory $orderTaxCollectionFactory, \Magento\Framework\Locale\ResolverInterface $localeResolver, \Magento\Catalog\Helper\Data $catalogHelper, \Magento\Tax\Api\OrderTaxManagementInterface $orderTaxManagement, \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency, ?\Magento\Framework\Serialize\Serializer\Json $serializer = null)
    {
        $this->___init();
        parent::__construct($context, $jsonHelper, $taxConfig, $storeManager, $localeFormat, $orderTaxCollectionFactory, $localeResolver, $catalogHelper, $orderTaxManagement, $priceCurrency, $serializer);
    }

    /**
     * {@inheritdoc}
     */
    public function applyTaxOnCustomPrice($store = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'applyTaxOnCustomPrice');
        return $pluginInfo ? $this->___callPlugins('applyTaxOnCustomPrice', func_get_args(), $pluginInfo) : parent::applyTaxOnCustomPrice($store);
    }

    /**
     * {@inheritdoc}
     */
    public function applyTaxOnOriginalPrice($store = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'applyTaxOnOriginalPrice');
        return $pluginInfo ? $this->___callPlugins('applyTaxOnOriginalPrice', func_get_args(), $pluginInfo) : parent::applyTaxOnOriginalPrice($store);
    }
}
