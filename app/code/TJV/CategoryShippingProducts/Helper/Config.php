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
    /** @var ScopeConfigInterface */
    private ScopeConfigInterface $scopeConfig;

    /** @var SerializerInterface */
    private SerializerInterface $serializer;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param SerializerInterface $serializer
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        SerializerInterface $serializer
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->serializer = $serializer;
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
        unset($decoded['_country_columns']);
        unset($decoded['_hidden_columns']);
        unset($decoded['_country_groups']);

        if ($countryId === '') {
            return $decoded;
        }

        $countryRates = [];
        $region = $this->getRegionForCountry($countryId);
        $groupId = $this->getGroupForCountry($countryId, $countryGroups);
        foreach ($decoded as $categoryId => $categoryRate) {
            if (!is_array($categoryRate)) {
                continue;
            }

            $countryRate = $categoryRate['countries'][$countryId] ?? null;
            $groupRate = $groupId ? ($categoryRate['groups'][$groupId] ?? null) : null;
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
                : ($this->hasRate($groupRate) ? $groupRate
                : ($this->hasRate($regionRate) ? $regionRate
                : [
                    'first' => $categoryRate['first'] ?? '',
                    'second' => $categoryRate['second'] ?? '',
                ]));
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
