<?php

namespace TJV\CategoryShippingProducts\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class Config
{
    private const XML_PATH_RATES = 'tjv_category_shipping_products/shipping_rates/rates';
    private const FIXED_COUNTRY_COLUMNS = ['IT'];
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
    /** @var ScopeConfigInterface */
    private ScopeConfigInterface $scopeConfig;

    /** @var SerializerInterface */
    private SerializerInterface $serializer;
    private StoreManagerInterface $storeManager;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param SerializerInterface $serializer
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        SerializerInterface $serializer,
        StoreManagerInterface $storeManager
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->serializer = $serializer;
        $this->storeManager = $storeManager;
    }

    /**
     * Convert a configured store-view currency amount to Magento's base currency.
     *
     * @param float $amount
     * @param int $storeId
     * @return float
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function convertRateToBaseCurrency(float $amount, int $storeId): float
    {
        $store = $this->storeManager->getStore($storeId);
        $storeCurrencyCode = $store->getDefaultCurrencyCode();
        $baseCurrency = $store->getBaseCurrency();
        $exchangeRate = (float)$baseCurrency->getRate($storeCurrencyCode);

        if ($exchangeRate <= 0.0) {
            throw new \Magento\Framework\Exception\LocalizedException(__(
                'The currency rate from %1 to %2 is not configured.',
                $store->getBaseCurrencyCode(),
                $storeCurrencyCode
            ));
        }

        return $amount / $exchangeRate;
    }

    /**
     * Return configured category rates, resolved for a destination country when provided.
     *
     * @param int $storeId
     * @param string $countryId
     * @return array
     */
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

        $countryGroups = $decoded['_country_groups'] ?? [];
        if (!is_array($countryGroups)) {
            $countryGroups = [];
        }
        $hiddenColumns = $decoded['_hidden_columns'] ?? [];
        if (!is_array($hiddenColumns)) {
            $hiddenColumns = [];
        }
        $hiddenColumns = array_fill_keys(
            array_filter($hiddenColumns, 'is_string'),
            true
        );
        $countryColumns = $decoded['_country_columns'] ?? [];
        if (!is_array($countryColumns)) {
            $countryColumns = [];
        }
        $countryColumns = array_fill_keys(
            array_filter($countryColumns, 'is_string'),
            true
        );
        unset($decoded['_country_columns']);
        unset($decoded['_hidden_columns']);
        unset($decoded['_country_groups']);

        if ($countryId === '') {
            return $decoded;
        }

        $countryRates = [];
        $region = $this->getRegionForCountry($countryId);
        $groupId = $this->getGroupForCountry($countryId, $countryGroups);
        if ($groupId !== null && isset($hiddenColumns['groups:' . $groupId])) {
            $groupId = null;
        }
        if ($region !== null && isset($hiddenColumns['regions:' . $region])) {
            $region = isset($hiddenColumns['regions:rest_of_world'])
                ? null
                : 'rest_of_world';
        }

        foreach ($decoded as $categoryId => $categoryRate) {
            if (!is_array($categoryRate)) {
                continue;
            }

            $countryRate = $categoryRate['countries'][$countryId] ?? null;
            $groupRate = $groupId ? ($categoryRate['groups'][$groupId] ?? null) : null;
            $regionRate = $region ? ($categoryRate['regions'][$region] ?? null) : null;
            $countryColumnIsVisible = isset($countryColumns[$countryId])
                || (in_array($countryId, self::FIXED_COUNTRY_COLUMNS, true)
                    && !isset($hiddenColumns['countries:' . $countryId]));
            if (!$countryColumnIsVisible
                || isset($hiddenColumns['countries:' . $countryId])
            ) {
                $countryRate = null;
            }
            if (!$this->hasRate($regionRate)) {
                $legacyRegion = [
                    'usa' => 'usa_canada',
                    'canada' => 'usa_canada',
                    'australia' => 'australia_new_zealand',
                    'new_zealand' => 'australia_new_zealand',
                ][$region] ?? null;
                $regionRate = $legacyRegion
                    && !isset($hiddenColumns['regions:' . $legacyRegion])
                    ? ($categoryRate['regions'][$legacyRegion] ?? null)
                    : null;
            }
            if ($this->hasRate($countryRate)) {
                $resolvedRate = $countryRate;
                $destinationPriority = 3;
            } elseif ($this->hasRate($groupRate)) {
                $resolvedRate = $groupRate;
                $destinationPriority = 2;
            } elseif ($this->hasRate($regionRate)) {
                $resolvedRate = $regionRate;
                $destinationPriority = 1;
            } else {
                $resolvedRate = [
                    'first' => $categoryRate['first'] ?? '',
                    'second' => $categoryRate['second'] ?? '',
                ];
                $destinationPriority = 0;
            }
            $resolvedRate['_destination_priority'] = $destinationPriority;
            $countryRates[(string)$categoryId] = $resolvedRate;
        }

        return $countryRates;
    }

    /**
     * Resolve a country to its configured region identifier.
     *
     * @param string $countryId
     * @return string|null
     */
    private function getRegionForCountry(string $countryId): ?string
    {
        foreach (self::REGIONS as $region => $countries) {
            if (in_array($countryId, $countries, true)) {
                return $region;
            }
        }

        return 'rest_of_world';
    }

    /**
     * Resolve a country to its custom group identifier, if configured.
     *
     * @param string $countryId
     * @param array $countryGroups
     * @return string|null
     */
    private function getGroupForCountry(string $countryId, array $countryGroups): ?string
    {
        $assignedCountries = [];
        foreach ($countryGroups as $groupId => $group) {
            if (!is_string($groupId) || !preg_match('/^group_[A-Z0-9_]+$/', $groupId)
                || !is_array($group) || !is_array($group['countries'] ?? null)
                || !is_string($group['name'] ?? null) || trim($group['name']) === ''
            ) {
                continue;
            }

            $countries = array_values(array_unique(array_filter(
                $group['countries'],
                static function ($id): bool {
                    return is_string($id) && preg_match('/^[A-Z0-9]{2,3}$/', $id) === 1;
                }
            )));
            sort($countries);
            if (count($countries) < 2) {
                continue;
            }

            foreach ($countries as $groupCountryId) {
                if (isset($assignedCountries[$groupCountryId])) {
                    continue 2;
                }
            }
            foreach ($countries as $groupCountryId) {
                $assignedCountries[$groupCountryId] = true;
            }
            if (in_array($countryId, $countries, true)) {
                return $groupId;
            }
        }

        return null;
    }

    /**
     * Check whether a rate array contains a configured amount.
     *
     * @param mixed $rate
     * @return bool
     */
    private function hasRate($rate): bool
    {
        return is_array($rate)
            && (($rate['first'] ?? '') !== '' || ($rate['second'] ?? '') !== '');
    }
}
