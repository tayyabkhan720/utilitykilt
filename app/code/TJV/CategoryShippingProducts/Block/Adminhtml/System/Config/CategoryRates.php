<?php

namespace TJV\CategoryShippingProducts\Block\Adminhtml\System\Config;

use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Escaper;
use Magento\Store\Model\StoreManagerInterface;

class CategoryRates extends Field
{
    private CollectionFactory $categoryCollectionFactory;
    private StoreManagerInterface $storeManager;
    private Escaper $escaper;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        CollectionFactory $categoryCollectionFactory,
        StoreManagerInterface $storeManager,
        Escaper $escaper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->storeManager = $storeManager;
        $this->escaper = $escaper;
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
        foreach ($topLevelCategories as $parent) {
            $html .= '<details open><summary><strong>' . $this->escaper->escapeHtml($parent->getName())
                . '</strong></summary>';
            $html .= '<table class="admin__control-table"><thead><tr><th>'
                . $this->escaper->escapeHtml(__('Category')) . '</th><th>'
                . $this->escaper->escapeHtml(__('First Product Shipping')) . '</th><th>'
                . $this->escaper->escapeHtml(__('Second Product Shipping'))
                . '</th></tr></thead><tbody>';
            $html .= $this->renderCategoryRows($parent, $children, $configured, $name, 0);
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
        int $depth
    ): string {
        $categoryId = (string)$category->getId();
        $row = $configured[$categoryId] ?? [];
        $first = $this->escaper->escapeHtmlAttr((string)($row['first'] ?? ''));
        $second = $this->escaper->escapeHtmlAttr((string)($row['second'] ?? ''));
        $label = str_repeat('&mdash; ', $depth) . $this->escaper->escapeHtml($category->getName());
        $html = '<tr><td>' . $label . ' <small>(ID: ' . $categoryId . ')</small></td>';
        foreach (['first', 'second'] as $rate) {
            $html .= '<td><input class="input-text" type="number" min="0" step="0.01" name="'
                . $this->escaper->escapeHtmlAttr($name . '[' . $categoryId . '][' . $rate . ']')
                . '" value="' . ($rate === 'first' ? $first : $second) . '" /></td>';
        }
        $html .= '</tr>';
        foreach ($children[(int)$category->getId()] ?? [] as $child) {
            $html .= $this->renderCategoryRows($child, $children, $configured, $name, $depth + 1);
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
        }

        return $normalized;
    }
}
