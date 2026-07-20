<?php
namespace Magento\Catalog\Model\Product\Type\FrontSpecialPrice;

/**
 * Interceptor class for @see \Magento\Catalog\Model\Product\Type\FrontSpecialPrice
 */
class Interceptor extends \Magento\Catalog\Model\Product\Type\FrontSpecialPrice implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\CatalogRule\Model\ResourceModel\RuleFactory $ruleFactory, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate, \Magento\Customer\Model\Session $customerSession, \Magento\Framework\Event\ManagerInterface $eventManager, \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency, \Magento\Customer\Api\GroupManagementInterface $groupManagement, \Magento\Catalog\Api\Data\ProductTierPriceInterfaceFactory $tierPriceFactory, \Magento\Framework\App\Config\ScopeConfigInterface $config, \Magento\Catalog\Model\ResourceModel\Product\Price\SpecialPrice $specialPrice)
    {
        $this->___init();
        parent::__construct($ruleFactory, $storeManager, $localeDate, $customerSession, $eventManager, $priceCurrency, $groupManagement, $tierPriceFactory, $config, $specialPrice);
    }

    /**
     * {@inheritdoc}
     */
    public function getFinalPrice($qty, $product)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getFinalPrice');
        return $pluginInfo ? $this->___callPlugins('getFinalPrice', func_get_args(), $pluginInfo) : parent::getFinalPrice($qty, $product);
    }
}
