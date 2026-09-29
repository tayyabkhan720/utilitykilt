<?php
namespace TJV\PromoShipping\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class PromoHelper extends AbstractHelper
{
    private const XML_PATH_TRIGGER_PRODUCT_IDS = 'tjv_promo/buy_one_free_shipping/trigger_product_ids';
    private const XML_PATH_FREE_SHIPPING_PRODUCT_IDS = 'tjv_promo/buy_one_free_shipping/free_shipping_product_ids';
    private const XML_PATH_ENABLED = 'tjv_promo/buy_one_free_shipping/enabled';

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Check whether the promotion is enabled for a store.
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isEnabled(?int $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Return configured trigger product IDs for a store.
     *
     * @param int|null $storeId
     * @return array
     */
    public function getTriggerProductIds(?int $storeId = null): array
    {
        return $this->getConfiguredValues(self::XML_PATH_TRIGGER_PRODUCT_IDS, $storeId);
    }

    /**
     * Return configured free-shipping product IDs for a store.
     *
     * @param int|null $storeId
     * @return array
     */
    public function getFreeShippingProductIds(?int $storeId = null): array
    {
        return $this->getConfiguredValues(self::XML_PATH_FREE_SHIPPING_PRODUCT_IDS, $storeId);
    }

    /**
     * Check whether a quote item matches a configured product ID or SKU.
     *
     * @param \Magento\Quote\Model\Quote\Item\AbstractItem $item
     * @param array $configuredProducts
     * @return bool
     */
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

    /**
     * Parse configured comma-separated product IDs or SKUs.
     *
     * @param string $path
     * @param int|null $storeId
     * @return array
     */
    private function getConfiguredValues(string $path, ?int $storeId): array
    {
        $productIds = $this->scopeConfig->getValue(
            $path,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );

        if (empty($productIds)) {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode(',', (string)$productIds))));
    }
}
