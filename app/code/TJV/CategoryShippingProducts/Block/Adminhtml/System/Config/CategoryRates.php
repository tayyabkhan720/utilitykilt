<?php

namespace TJV\CategoryShippingProducts\Block\Adminhtml\System\Config;

use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Directory\Model\ResourceModel\Country\CollectionFactory as CountryCollectionFactory;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Escaper;
use Magento\Store\Model\StoreManagerInterface;

class CategoryRates extends Field
{
    private const COUNTRY_COLUMNS_CONFIG_KEY = '_country_columns';
    private const HIDDEN_COLUMNS_CONFIG_KEY = '_hidden_columns';
    private CollectionFactory $categoryCollectionFactory;
    private StoreManagerInterface $storeManager;
    private Escaper $escaper;
    private CountryCollectionFactory $countryCollectionFactory;
    private const REGIONS = [
        'uk' => 'United Kingdom',
        'europe' => 'Europe (excluding UK)',
        'usa' => 'USA',
        'canada' => 'Canada',
        'australia' => 'Australia',
        'new_zealand' => 'New Zealand',
        'rest_of_world' => 'Rest of the World',
    ];
    private const COUNTRY_COLUMNS = [
        'United Kingdom' => ['id' => 'uk', 'scope' => 'regions'],
        'Europe' => ['id' => 'europe', 'scope' => 'regions'],
        'USA' => ['id' => 'usa', 'scope' => 'regions'],
        'Canada' => ['id' => 'canada', 'scope' => 'regions'],
        'Australia' => ['id' => 'australia', 'scope' => 'regions'],
        'New Zealand' => ['id' => 'new_zealand', 'scope' => 'regions'],
        'Italy' => ['id' => 'IT', 'scope' => 'countries'],
    ];

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        CollectionFactory $categoryCollectionFactory,
        StoreManagerInterface $storeManager,
        Escaper $escaper,
        array $data = [],
        ?CountryCollectionFactory $countryCollectionFactory = null
    ) {
        parent::__construct($context, $data);
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->storeManager = $storeManager;
        $this->escaper = $escaper;
        $this->countryCollectionFactory = $countryCollectionFactory
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(CountryCollectionFactory::class);
    }

    protected function _getElementHtml(AbstractElement $element)
    {
        $storeId = (int)$this->getRequest()->getParam('store', 0);
        if ($storeId <= 0) {
            $storeId = (int)$this->storeManager->getDefaultStoreView()->getId();
        }
        $store = $this->storeManager->getStore($storeId);
        $rootCategoryId = (int)$store->getRootCategoryId();
        $value = $element->getValue();
        $configured = is_array($value) ? $value : [];
        $configured = array_replace($configured, $this->normalizeRows($configured));
        $regions = ['' => (string)__('Default')] + self::REGIONS;
        $countries = [];
        foreach ($this->countryCollectionFactory->create() as $country) {
            $countries[(string)$country->getCountryId()] = (string)$country->getName()
                . ' (' . (string)$country->getCountryId() . ')';
        }
        asort($countries);
        $countryColumns = $configured[self::COUNTRY_COLUMNS_CONFIG_KEY] ?? [];
        if (!is_array($countryColumns)) {
            $countryColumns = [];
        }
        $fixedCountryIds = [];
        foreach (self::COUNTRY_COLUMNS as $destination) {
            if ($destination['scope'] === 'countries') {
                $fixedCountryIds[] = $destination['id'];
            }
        }
        $countryColumns = array_values(array_unique(array_filter(
            $countryColumns,
            static function ($countryId) use ($countries, $fixedCountryIds): bool {
                return is_string($countryId)
                    && isset($countries[$countryId])
                    && !in_array($countryId, $fixedCountryIds, true);
            }
        )));
        $hiddenColumns = $configured[self::HIDDEN_COLUMNS_CONFIG_KEY] ?? [];
        if (!is_array($hiddenColumns)) {
            $hiddenColumns = [];
        }
        $hiddenColumns = array_values(array_unique(array_filter(
            $hiddenColumns,
            static function ($destinationKey): bool {
                return is_string($destinationKey)
                    && preg_match('/^(regions|countries):[A-Z_a-z0-9]+$/', $destinationKey) === 1;
            }
        )));
        $configuredCountryIds = $this->getConfiguredCountryIds($configured, $countries);

        $collection = $this->categoryCollectionFactory->create();
        $collection->setStoreId($storeId)
            ->addAttributeToSelect('name')
            ->addAttributeToFilter('is_active', 1);
        if ($rootCategoryId > 0) {
            $collection->addFieldToFilter('path', ['like' => '1/' . $rootCategoryId . '/%']);
        }
        $collection
            ->addFieldToSelect(['parent_id', 'path'])
            ->setOrder('position', 'ASC');

        $name = $element->getName();
        $categories = [];
        foreach ($collection as $category) {
            $categories[(int)$category->getId()] = $category;
        }

        $children = [];
        foreach ($categories as $category) {
            $children[(int)$category->getParentId()][] = $category;
        }

        $topLevelCategories = $children[(int)$rootCategoryId] ?? [];
        if (!$topLevelCategories) {
            $categoryIds = array_keys($categories);
            foreach ($categories as $category) {
                if (!in_array((int)$category->getParentId(), $categoryIds, true)) {
                    $topLevelCategories[] = $category;
                }
            }
        }

        $html = '<div class="tjv-category-rates" data-remove-label="'
            . $this->escaper->escapeHtmlAttr(__('Remove'))
            . '" data-mage-init=\'{"TJV_CategoryShippingProducts/js/category-rates":{}}\'>';
        $html .= '<p><strong>' . $this->escaper->escapeHtml(__('Configure rates by destination country.'))
            . '</strong></p>';
        $html .= '<div class="tjv-category-rates__country-controls" style="margin:12px 0;">'
            . '<label for="tjv-category-rates-country">'
            . $this->escaper->escapeHtml(__('Add country to the table')) . '</label> '
            . '<select id="tjv-category-rates-country" data-role="country-select">'
            . '<option value="">' . $this->escaper->escapeHtml(__('Select a country')) . '</option>';
        foreach ($countries as $countryId => $countryName) {
            if (in_array($countryId, $fixedCountryIds, true)) {
                if (!in_array('countries:' . $countryId, $hiddenColumns, true)) {
                    continue;
                }
                $destinationKey = 'countries:' . $countryId;
            } else {
                $destinationKey = 'countries:' . $countryId;
            }
            $html .= '<option value="' . $this->escaper->escapeHtmlAttr($destinationKey) . '"'
                . (in_array($countryId, $fixedCountryIds, true) ? ' data-base-column="true"' : '')
                . (in_array($countryId, $countryColumns, true) ? ' hidden="hidden"' : '') . '>'
                . $this->escaper->escapeHtml($countryName) . '</option>';
        }
        foreach (self::COUNTRY_COLUMNS as $countryName => $destination) {
            if ($destination['scope'] !== 'regions') {
                continue;
            }
            $destinationKey = $destination['scope'] . ':' . $destination['id'];
            if (in_array($destinationKey, $hiddenColumns, true)) {
                $html .= '<option value="' . $this->escaper->escapeHtmlAttr($destinationKey)
                    . '" data-base-column="true">'
                    . $this->escaper->escapeHtml(__($countryName)) . '</option>';
            }
        }
        $html .= '</select> <button type="button" class="action-secondary" data-action="add-country">'
            . '<span>' . $this->escaper->escapeHtml(__('Add country')) . '</span></button>';
        $html .= '<input type="hidden" name="'
            . $this->escaper->escapeHtmlAttr($name . '[' . self::COUNTRY_COLUMNS_CONFIG_KEY . '][]')
            . '" value="" data-role="country-column" />';
        foreach ($countryColumns as $countryId) {
            $html .= '<input type="hidden" name="'
                . $this->escaper->escapeHtmlAttr($name . '[' . self::COUNTRY_COLUMNS_CONFIG_KEY . '][]')
                . '" value="' . $this->escaper->escapeHtmlAttr($countryId)
                . '" data-role="country-column" data-country-id="'
                . $this->escaper->escapeHtmlAttr($countryId) . '" />';
        }
        $html .= '<input type="hidden" name="'
            . $this->escaper->escapeHtmlAttr($name . '[' . self::HIDDEN_COLUMNS_CONFIG_KEY . '][]')
            . '" value="" data-role="hidden-column" />';
        foreach ($hiddenColumns as $destinationKey) {
            $html .= '<input type="hidden" name="'
                . $this->escaper->escapeHtmlAttr($name . '[' . self::HIDDEN_COLUMNS_CONFIG_KEY . '][]')
                . '" value="' . $this->escaper->escapeHtmlAttr($destinationKey)
                . '" data-role="hidden-column" data-destination-key="'
                . $this->escaper->escapeHtmlAttr($destinationKey) . '" />';
        }
        $html .= '</div>';
        $visibleDestinations = [];
        foreach (self::COUNTRY_COLUMNS as $destination) {
            $key = $destination['scope'] . ':' . $destination['id'];
            if (!in_array($key, $hiddenColumns, true)) {
                $visibleDestinations[] = $destination;
            }
        }
        foreach ($countryColumns as $countryId) {
            $visibleDestinations[] = ['id' => $countryId, 'scope' => 'countries'];
        }
        $columnCount = count($visibleDestinations);
        $html .= '<div class="tjv-category-rates__country-table"'
            . ' style="display:block;width:100%;max-width:100%;min-width:0;overflow-x:auto;'
            . 'overflow-y:hidden;box-sizing:border-box;">'
            . '<table class="admin__control-table"'
            . ' style="width:' . (340 * $columnCount) . 'px;min-width:' . (340 * $columnCount)
            . 'px;table-layout:fixed;border-collapse:collapse;" data-role="country-table">'
            . '<thead><tr data-role="country-table-head">';
        foreach (self::COUNTRY_COLUMNS as $countryName => $destination) {
            $destinationKey = $destination['scope'] . ':' . $destination['id'];
            if (in_array($destinationKey, $hiddenColumns, true)) {
                continue;
            }
            $html .= '<th style="width:340px;border:1px solid #c6c6c6;padding:8px;"'
                . ' data-country-column="' . $this->escaper->escapeHtmlAttr($destinationKey)
                . '" data-destination-key="' . $this->escaper->escapeHtmlAttr($destinationKey)
                . '" data-country-label="' . $this->escaper->escapeHtmlAttr(__($countryName)) . '">'
                . $this->escaper->escapeHtml(__($countryName)) . ' '
                . '<button type="button" class="action-secondary" data-action="remove-country"'
                . ' data-destination-key="' . $this->escaper->escapeHtmlAttr($destinationKey)
                . '" data-base-column="true">'
                . '<span>' . $this->escaper->escapeHtml(__('Remove')) . '</span></button></th>';
        }
        foreach ($countryColumns as $countryId) {
            $html .= '<th style="width:340px;border:1px solid #c6c6c6;padding:8px;"'
                . ' data-country-column="countries:' . $this->escaper->escapeHtmlAttr($countryId)
                . '" data-destination-key="countries:' . $this->escaper->escapeHtmlAttr($countryId)
                . '" data-country-label="' . $this->escaper->escapeHtmlAttr($countries[$countryId]) . '">'
                . $this->escaper->escapeHtml($countries[$countryId]) . ' '
                . '<button type="button" class="action-secondary" data-action="remove-country"'
                . ' data-destination-key="countries:' . $this->escaper->escapeHtmlAttr($countryId) . '">'
                . '<span>' . $this->escaper->escapeHtml(__('Remove')) . '</span></button></th>';
        }

        $html .= '</tr></thead><tbody><tr data-role="country-table-row">';
        foreach (self::COUNTRY_COLUMNS as $destination) {
            $destinationKey = $destination['scope'] . ':' . $destination['id'];
            if (in_array($destinationKey, $hiddenColumns, true)) {
                continue;
            }
            $html .= '<td style="width:340px;vertical-align:top;border:1px solid #c6c6c6;padding:8px;"'
                . ' data-country-column="' . $this->escaper->escapeHtmlAttr($destinationKey) . '">'
                . $this->renderDestinationTable(
                    $topLevelCategories,
                    $children,
                    $configured,
                    $name,
                    $destination['id'],
                    $destination['scope']
                ) . '</td>';
        }
        foreach ($countryColumns as $countryId) {
            $html .= '<td style="width:340px;vertical-align:top;border:1px solid #c6c6c6;padding:8px;"'
                . ' data-country-column="countries:' . $this->escaper->escapeHtmlAttr($countryId) . '">'
                . $this->renderDestinationTable(
                    $topLevelCategories,
                    $children,
                    $configured,
                    $name,
                    $countryId,
                    'countries'
                ) . '</td>';
        }
        $html .= '</tr></tbody></table></div>';

        $primaryRegionIds = [];
        foreach (self::COUNTRY_COLUMNS as $destination) {
            if ($destination['scope'] === 'regions') {
                $primaryRegionIds[] = $destination['id'];
            }
        }
        $html .= '<details class="tjv-category-rates__other-destinations"><summary><strong>'
            . $this->escaper->escapeHtml(__('Default and other destinations'))
            . '</strong></summary>';
        foreach ($regions as $regionId => $regionName) {
            if ($regionId !== '' && in_array($regionId, $primaryRegionIds, true)
                && !in_array('regions:' . $regionId, $hiddenColumns, true)
            ) {
                continue;
            }
            $html .= '<details data-destination-key="regions:' . $this->escaper->escapeHtmlAttr($regionId)
                . '"><summary><strong>'
                . $this->escaper->escapeHtml(__($regionName)) . '</strong></summary>';
            $html .= $this->renderDestinationTable(
                $topLevelCategories,
                $children,
                $configured,
                $name,
                $regionId
            ) . '</details>';
        }
        foreach ($countries as $countryId => $countryName) {
            if ((in_array($countryId, $fixedCountryIds, true)
                    && !in_array('countries:' . $countryId, $hiddenColumns, true))
                || in_array($countryId, $countryColumns, true)
                || (!in_array($countryId, $configuredCountryIds, true)
                    && !in_array('countries:' . $countryId, $hiddenColumns, true))
            ) {
                continue;
            }
            $html .= '<details data-destination-key="countries:' . $this->escaper->escapeHtmlAttr($countryId)
                . '" data-country-destination="' . $this->escaper->escapeHtmlAttr($countryId)
                . '"><summary><strong>' . $this->escaper->escapeHtml($countryName)
                . '</strong></summary>';
            $html .= $this->renderDestinationTable(
                $topLevelCategories,
                $children,
                $configured,
                $name,
                $countryId,
                'countries'
            ) . '</details>';
        }
        $html .= '</details>';
        $html .= '<template data-role="country-template">'
            . $this->renderDestinationTable(
                $topLevelCategories,
                $children,
                $configured,
                $name,
                '__COUNTRY__',
                'countries'
            )
            . '</template>';
        $html .= '<template data-role="region-template">'
            . $this->renderDestinationTable(
                $topLevelCategories,
                $children,
                $configured,
                $name,
                '__DESTINATION__',
                'regions'
            )
            . '</template>';

        $html .= '</div>';
        return $html;
    }

    private function renderDestinationTable(
        array $topLevelCategories,
        array $children,
        array $configured,
        string $name,
        string $destinationId,
        string $scope = 'regions'
    ): string {
        $html = '<table class="admin__control-table"'
            . ' style="width:100%;table-layout:fixed;border-collapse:collapse;">'
            . '<colgroup><col style="width:40%;"><col style="width:30%;"><col style="width:30%;"></colgroup>'
            . '<thead><tr><th style="border:1px solid #c6c6c6;padding:6px;">'
            . $this->escaper->escapeHtml(__('Category')) . '</th><th'
            . ' style="border:1px solid #c6c6c6;padding:6px;">'
            . $this->escaper->escapeHtml(__('First Product Shipping')) . '</th><th'
            . ' style="border:1px solid #c6c6c6;padding:6px;">'
            . $this->escaper->escapeHtml(__('Others Product Shipping'))
            . '</th></tr></thead><tbody>';
        foreach ($topLevelCategories as $parent) {
            $html .= $this->renderCategoryRows(
                $parent,
                $children,
                $configured,
                $name,
                $destinationId,
                0,
                $scope
            );
        }

        return $html . '</tbody></table>';
    }

    private function renderCategoryRows(
        $category,
        array $children,
        array $configured,
        string $name,
        string $regionId,
        int $depth,
        string $scope = 'regions'
    ): string {
        $categoryId = (string)$category->getId();
        $categoryConfig = $configured[$categoryId] ?? [];
        $row = $regionId === ''
            ? $categoryConfig
            : ($categoryConfig[$scope][$regionId] ?? []);
        if ($regionId !== '' && (!$row || (($row['first'] ?? '') === '' && ($row['second'] ?? '') === ''))) {
            $legacyRegion = [
                'usa' => 'usa_canada',
                'canada' => 'usa_canada',
                'australia' => 'australia_new_zealand',
                'new_zealand' => 'australia_new_zealand',
            ][$regionId] ?? null;
            $row = $scope === 'regions' && $legacyRegion
                ? ($categoryConfig['regions'][$legacyRegion] ?? $row)
                : $row;
        }
        $first = $this->escaper->escapeHtmlAttr((string)($row['first'] ?? ''));
        $second = $this->escaper->escapeHtmlAttr((string)($row['second'] ?? ''));
        $label = str_repeat('&mdash; ', $depth) . $this->escaper->escapeHtml($category->getName());
        $ratePath = $regionId === ''
            ? $name . '[' . $categoryId . ']'
            : $name . '[' . $categoryId . '][' . $scope . '][' . $regionId . ']';
        $cellStyle = 'border:1px solid #d5d5d5;padding:6px;vertical-align:top;';
        $html = '<tr><td style="' . $cellStyle . '">' . $label . '</td>';
        foreach (['first', 'second'] as $rate) {
            $html .= '<td style="' . $cellStyle . '"><input class="input-text"'
                . ' style="width:90px;max-width:100%;box-sizing:border-box;"'
                . ' type="number" min="0" step="0.01" name="'
                . $this->escaper->escapeHtmlAttr($ratePath . '[' . $rate . ']')
                . '" value="' . ($rate === 'first' ? $first : $second) . '" /></td>';
        }
        $html .= '</tr>';

        $childCategories = $children[(int)$category->getId()] ?? [];
        if ($childCategories) {
            $html .= '<tr><td colspan="3" style="' . $cellStyle
                . '"><details class="tjv-category-rates__children"><summary>'
                . $this->escaper->escapeHtml(__('Show subcategories (%1)', count($childCategories)))
                . '</summary><table class="admin__control-table"'
                . ' style="width:100%;table-layout:fixed;border-collapse:collapse;">'
                . '<colgroup><col style="width:40%;"><col style="width:30%;"><col style="width:30%;"></colgroup>'
                . '<tbody>';
            foreach ($childCategories as $child) {
                $html .= $this->renderCategoryRows(
                    $child,
                    $children,
                    $configured,
                    $name,
                    $regionId,
                    $depth + 1,
                    $scope
                );
            }
            $html .= '</tbody></table></details></td></tr>';
        }

        return $html;
    }

    private function normalizeRows(array $rows): array
    {
        $normalized = [];
        foreach ($rows as $categoryId => $row) {
            if (!is_array($row)) {
                continue;
            }

            if ((string)$categoryId === self::COUNTRY_COLUMNS_CONFIG_KEY) {
                $normalized[self::COUNTRY_COLUMNS_CONFIG_KEY] = array_values(array_filter(
                    $row,
                    static function ($countryId): bool {
                        return is_string($countryId) && $countryId !== '';
                    }
                ));
                continue;
            }
            if ((string)$categoryId === self::HIDDEN_COLUMNS_CONFIG_KEY) {
                $normalized[self::HIDDEN_COLUMNS_CONFIG_KEY] = array_values(array_filter(
                    $row,
                    static function ($destinationKey): bool {
                        return is_string($destinationKey) && $destinationKey !== '';
                    }
                ));
                continue;
            }

            $normalized[(string)$categoryId] = [
                'first' => $row['first'] ?? '',
                'second' => $row['second'] ?? '',
            ];
            if (isset($row['countries']) && is_array($row['countries'])) {
                $normalized[(string)$categoryId]['countries'] = $row['countries'];
            }
            if (isset($row['regions']) && is_array($row['regions'])) {
                $normalized[(string)$categoryId]['regions'] = $row['regions'];
            }
        }

        return $normalized;
    }

    private function getConfiguredCountryIds(array $configured, array $countries): array
    {
        $countryIds = [];
        foreach ($configured as $categoryId => $categoryConfig) {
            if ((string)$categoryId === self::COUNTRY_COLUMNS_CONFIG_KEY || !is_array($categoryConfig)) {
                continue;
            }
            foreach (($categoryConfig['countries'] ?? []) as $countryId => $rate) {
                if (isset($countries[$countryId])
                    && is_array($rate)
                    && (($rate['first'] ?? '') !== '' || ($rate['second'] ?? '') !== '')
                ) {
                    $countryIds[$countryId] = $countryId;
                }
            }
        }

        return array_values($countryIds);
    }
}
