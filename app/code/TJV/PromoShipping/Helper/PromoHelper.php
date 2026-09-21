<?php
namespace TJV\PromoShipping\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class PromoHelper extends AbstractHelper
{
    const XML_PATH_TRIGGER_PRODUCT_IDS = 'tjv_promo/buy_one_free_shipping/trigger_product_ids';
    const XML_PATH_FREE_SHIPPING_PRODUCT_IDS = 'tjv_promo/buy_one_free_shipping/free_shipping_product_ids';
    const XML_PATH_ENABLED = 'tjv_promo/buy_one_free_shipping/enabled';

    protected $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function isEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getTriggerProductIds(): array
    {
        return $this->getConfiguredValues(self::XML_PATH_TRIGGER_PRODUCT_IDS);
    }

    public function getFreeShippingProductIds(): array
    {
        return $this->getConfiguredValues(self::XML_PATH_FREE_SHIPPING_PRODUCT_IDS);
    }

    public function matchesProduct($item, array $configuredProducts): bool
    {
        $productId = (string)$item->getProductId();
        $sku = (string)$item->getSku();
        $productSku = (string)$item->getProduct()->getSku();

        if (in_array($productId, $configuredProducts, true)) {
            return true;
        }

        foreach ($configuredProducts as $configuredProduct) {
            if ($sku === $configuredProduct
                || $productSku === $configuredProduct
                || ($sku !== '' && strpos($sku, $configuredProduct . '-') === 0)
                || ($productSku !== '' && strpos($productSku, $configuredProduct . '-') === 0)
            ) {
                return true;
            }
        }

        return false;
    }

    private function getConfiguredValues(string $path): array
    {
        $productIds = $this->scopeConfig->getValue(
            $path,
            ScopeInterface::SCOPE_STORE
        );

        if (empty($productIds)) {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode(',', (string)$productIds))));
    }
}