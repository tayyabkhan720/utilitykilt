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

        $html = '<div class="tjv-category-rates">';
        $html .= '<p><strong>' . $this->escaper->escapeHtml(__('Configure rates by destination country.'))
            . '</strong></p>';
        $html .= '<div class="tjv-category-rates__country-table"'
            . ' style="display:block;width:100%;max-width:100%;min-width:0;overflow-x:auto;'
            . 'overflow-y:hidden;box-sizing:border-box;">'
            . '<table class="admin__control-table"'
            . ' style="width:2380px;min-width:2380px;table-layout:fixed;border-collapse:collapse;">'
            . '<thead><tr>';
        foreach (self::COUNTRY_COLUMNS as $countryName => $destination) {
            $html .= '<th style="width:340px;border:1px solid #c6c6c6;padding:8px;">'
                . $this->escaper->escapeHtml(__($countryName)) . '</th>';
        }

        $html .= '</tr></thead><tbody><tr>';
        foreach (self::COUNTRY_COLUMNS as $destination) {
            $html .= '<td style="width:340px;vertical-align:top;border:1px solid #c6c6c6;padding:8px;">'
                . $this->renderDestinationTable(
                $topLevelCategories,
                $children,
                $configured,
                $name,
                $destination['id'],
                $destination['scope']
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
            if ($regionId !== '' && in_array($regionId, $primaryRegionIds, true)) {
                continue;
            }
            $html .= '<details><summary><strong>'
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
            if ($countryId === 'IT') {
                continue;
            }
            $html .= '<details><summary><strong>' . $this->escaper->escapeHtml($countryName)
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
        $html = '<tr><td style="' . $cellStyle . '">' . $label
            . ' <small>(ID: ' . $categoryId . ')</small></td>';
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
}
