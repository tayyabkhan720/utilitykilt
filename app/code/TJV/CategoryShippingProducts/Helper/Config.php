<?php

namespace TJV\CategoryShippingProducts\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    private const XML_PATH_RATES = 'tjv_category_shipping_products/shipping_rates/rates';
    private ScopeConfigInterface $scopeConfig;
    private SerializerInterface $serializer;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        SerializerInterface $serializer
    )
    {
        $this->scopeConfig = $scopeConfig;
        $this->serializer = $serializer;
    }

    public function getRates(int $storeId): array
    {
        $value = $this->scopeConfig->getValue(
            self::XML_PATH_RATES,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );

        if (is_array($value)) {
            return $value;
        }

        if (!$value) {
            return [];
        }

        try {
            $decoded = $this->serializer->unserialize((string)$value);
        } catch (\InvalidArgumentException $exception) {
            return [];
        }

        return is_array($decoded) ? $decoded : [];
    }
}
