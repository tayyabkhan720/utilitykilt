<?php

namespace TJV\CategoryShippingProducts\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    private const XML_PATH_RATES = 'tjv_category_shipping_products/shipping_rates/rates';
    private const REGIONS = [
        'uk' => ['GB'],
        'europe' => [
            'AD', 'AL', 'AT', 'BA', 'BE', 'BG', 'BY', 'CH', 'CY', 'CZ', 'DE', 'DK', 'EE',
            'ES', 'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IS', 'IT', 'LI', 'LT', 'LU', 'LV',
            'MC', 'MD', 'ME', 'MK', 'MT', 'NL', 'NO', 'PL', 'PT', 'RO', 'RS', 'RU', 'SE',
            'SI', 'SK', 'SM', 'TR', 'UA', 'VA', 'XK',
        ],
        'usa' => ['US'],
        'canada' => ['CA'],
        'australia' => ['AU'],
        'new_zealand' => ['NZ'],
    ];
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

    public function getRates(int $storeId, string $countryId = ''): array
    {
        $value = $this->scopeConfig->getValue(
            self::XML_PATH_RATES,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );

        if (is_array($value)) {
            $decoded = $value;
        } elseif (!$value) {
            return [];
        } else {
            try {
                $decoded = $this->serializer->unserialize((string)$value);
            } catch (\InvalidArgumentException $exception) {
                return [];
            }
        }

        if (!is_array($decoded)) {
            return [];
        }

        if ($countryId === '') {
            return $decoded;
        }

        $countryRates = [];
        $region = $this->getRegionForCountry($countryId);
        foreach ($decoded as $categoryId => $categoryRate) {
            if (!is_array($categoryRate)) {
                continue;
            }

            $countryRate = $categoryRate['countries'][$countryId] ?? null;
            $regionRate = $region ? ($categoryRate['regions'][$region] ?? null) : null;
            if (!$this->hasRate($regionRate)) {
                $legacyRegion = [
                    'usa' => 'usa_canada',
                    'canada' => 'usa_canada',
                    'australia' => 'australia_new_zealand',
                    'new_zealand' => 'australia_new_zealand',
                ][$region] ?? null;
                $regionRate = $legacyRegion
                    ? ($categoryRate['regions'][$legacyRegion] ?? null)
                    : null;
            }
            $countryRates[(string)$categoryId] = $this->hasRate($countryRate)
                ? $countryRate
                : ($this->hasRate($regionRate) ? $regionRate
                : [
                    'first' => $categoryRate['first'] ?? '',
                    'second' => $categoryRate['second'] ?? '',
                ]);
        }

        return $countryRates;
    }

    private function getRegionForCountry(string $countryId): ?string
    {
        foreach (self::REGIONS as $region => $countries) {
            if (in_array($countryId, $countries, true)) {
                return $region;
            }
        }

        return 'rest_of_world';
    }

    private function hasRate($rate): bool
    {
        return is_array($rate)
            && (($rate['first'] ?? '') !== '' || ($rate['second'] ?? '') !== '');
    }
}
