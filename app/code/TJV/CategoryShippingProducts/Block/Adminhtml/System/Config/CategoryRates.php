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
        foreach ($regions as $regionId => $regionName) {
            $html .= '<details' . ($regionId === '' ? ' open' : '') . '><summary><strong>'
                . $this->escaper->escapeHtml(__($regionName)) . '</strong></summary>';
            $html .= '<table class="admin__control-table"><thead><tr><th>'
                . $this->escaper->escapeHtml(__('Category')) . '</th><th>'
                . $this->escaper->escapeHtml(__('First Product Shipping')) . '</th><th>'
                . $this->escaper->escapeHtml(__('Second Product Shipping'))
                . '</th></tr></thead><tbody>';
            foreach ($topLevelCategories as $parent) {
                $html .= $this->renderCategoryRows(
                    $parent,
                    $children,
                    $configured,
                    $name,
                    $regionId,
                    0
                );
            }
            $html .= '</tbody></table></details>';
        }
        foreach ($countries as $countryId => $countryName) {
            $html .= '<details><summary><strong>' . $this->escaper->escapeHtml($countryName)
                . '</strong></summary>';
            $html .= '<table class="admin__control-table"><thead><tr><th>'
                . $this->escaper->escapeHtml(__('Category')) . '</th><th>'
                . $this->escaper->escapeHtml(__('First Product Shipping')) . '</th><th>'
                . $this->escaper->escapeHtml(__('Second Product Shipping'))
                . '</th></tr></thead><tbody>';
            foreach ($topLevelCategories as $parent) {
                $html .= $this->renderCategoryRows(
                    $parent,
                    $children,
                    $configured,
                    $name,
                    $countryId,
                    0,
                    'countries'
                );
            }
            $html .= '</tbody></table></details>';
        }

        $html .= '</div>';
        return $html;
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
        $html = '<tr><td>' . $label . ' <small>(ID: ' . $categoryId . ')</small></td>';
        foreach (['first', 'second'] as $rate) {
            $html .= '<td><input class="input-text" type="number" min="0" step="0.01" name="'
                . $this->escaper->escapeHtmlAttr($ratePath . '[' . $rate . ']')
                . '" value="' . ($rate === 'first' ? $first : $second) . '" /></td>';
        }
        $html .= '</tr>';
        foreach ($children[(int)$category->getId()] ?? [] as $child) {
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
