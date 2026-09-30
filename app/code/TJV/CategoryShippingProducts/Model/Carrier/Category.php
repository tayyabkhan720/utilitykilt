<?php

namespace TJV\CategoryShippingProducts\Model\Carrier;

use Magento\Catalog\Model\CategoryRepository;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Quote\Model\Quote\Address\RateResult\MethodFactory;
use Magento\Shipping\Model\Carrier\AbstractCarrier;
use Magento\Shipping\Model\Carrier\CarrierInterface;
use Magento\Shipping\Model\Rate\Result;
use Magento\Shipping\Model\Rate\ResultFactory;
use Psr\Log\LoggerInterface;
use TJV\CategoryShippingProducts\Helper\Config as CategoryShippingConfig;
use TJV\PromoShipping\Helper\PromoHelper;

class Category extends AbstractCarrier implements CarrierInterface
{
    /** @var string */
    protected $_code = 'tjv_category';

    /** @var ResultFactory */
    private ResultFactory $rateResultFactory;

    /** @var MethodFactory */
    private MethodFactory $rateMethodFactory;

    /** @var CategoryRepository */
    private CategoryRepository $categoryRepository;

    /** @var CategoryShippingConfig */
    private CategoryShippingConfig $categoryShippingConfig;

    /** @var PromoHelper */
    private PromoHelper $promoHelper;

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory
     * @param LoggerInterface $logger
     * @param ResultFactory $rateResultFactory
     * @param MethodFactory $rateMethodFactory
     * @param CategoryRepository $categoryRepository
     * @param CategoryShippingConfig $categoryShippingConfig
     * @param PromoHelper $promoHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory,
        LoggerInterface $logger,
        ResultFactory $rateResultFactory,
        MethodFactory $rateMethodFactory,
        CategoryRepository $categoryRepository,
        CategoryShippingConfig $categoryShippingConfig,
        PromoHelper $promoHelper,
        array $data = []
    ) {
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
        $this->rateResultFactory = $rateResultFactory;
        $this->rateMethodFactory = $rateMethodFactory;
        $this->categoryRepository = $categoryRepository;
        $this->categoryShippingConfig = $categoryShippingConfig;
        $this->promoHelper = $promoHelper;
    }

    /**
     * Collect the category-based shipping rate for the quote items.
     *
     * @param RateRequest $request
     * @return Result|bool
     */
    public function collectRates(RateRequest $request)
    {
        if ($this->getConfigData('active') === '0' || !$request->getAllItems()) {
            return false;
        }

        $items = $request->getAllItems();
        $storeId = (int)$request->getStoreId();
        $triggerCategoryIds = $this->promoHelper->getTriggerCategoryIds($storeId);
        $freeShippingCategoryIds = $this->promoHelper->getFreeShippingCategoryIds($storeId);
        $promoApplies = $this->isPromoApplicable(
            $items,
            $triggerCategoryIds,
            $freeShippingCategoryIds,
            $storeId
        );
        $categoryIds = [];
        foreach ($items as $item) {
            $isPromoFree = $promoApplies
                && $this->promoHelper->matchesCategories($item, $freeShippingCategoryIds)
                && !$this->promoHelper->matchesCategories($item, $triggerCategoryIds);
            if ($item->getParentItem()
                || $item->getProduct()->isVirtual()
                || $item->getFreeShipping()
                || $isPromoFree
            ) {
                continue;
            }

            $categoryIds[] = [
                'ids' => $item->getProduct()->getCategoryIds(),
                'qty' => max(1, (int)$item->getQty()),
            ];
        }

        $categoryRates = [];
        $categoryRateById = [];
        $configuredRates = $this->categoryShippingConfig->getRates(
            (int)$request->getStoreId(),
            (string)$request->getDestCountryId()
        );
        foreach ($categoryIds as $itemCategories) {
            $itemRateSources = [];
            foreach (array_unique(array_map('intval', $itemCategories['ids'])) as $categoryId) {
                try {
                    if (!array_key_exists($categoryId, $categoryRateById)) {
                        $categoryRateById[$categoryId] = $this->getCategoryRate(
                            $categoryId,
                            (int)$request->getStoreId(),
                            $configuredRates
                        );
                    }
                    $rate = $categoryRateById[$categoryId];
                    if ($rate !== null) {
                        $itemRateSources[(int)$rate['source_id']] = $rate;
                    }
                } catch (\Magento\Framework\Exception\NoSuchEntityException $exception) {
                    $categoryRateById[$categoryId] = null;
                    $this->_logger->warning(
                        'Unable to load category for category shipping rate.',
                        ['category_id' => $categoryId, 'exception' => $exception]
                    );
                }
            }

            $itemRateSources = $this->removeAncestorRates($itemRateSources);
            foreach ($itemRateSources as $sourceId => $rate) {
                if (!isset($categoryRates[$sourceId])) {
                    $categoryRates[$sourceId] = [
                        'first' => $rate['first'],
                        'second' => $rate['second'],
                        'qty' => 0,
                    ];
                }
                $categoryRates[$sourceId]['qty'] += $itemCategories['qty'];
            }
        }

        $baseAmount = 0.0;
        foreach ($categoryRates as $categoryRate) {
            $baseAmount += $categoryRate['first'];
            if ($categoryRate['qty'] > 1) {
                $baseAmount += $categoryRate['second'] * ($categoryRate['qty'] - 1);
            }
        }

        if ($baseAmount <= 0.0) {
            return false;
        }

        /** @var Result $result */
        $result = $this->rateResultFactory->create();
        $method = $this->rateMethodFactory->create();
        $method->setCarrier($this->_code);
        $method->setCarrierTitle((string)$this->getConfigData('title'));
        $method->setMethod('category');
        $method->setMethodTitle((string)$this->getConfigData('name'));
        $method->setPrice($baseAmount);
        $method->setCost($baseAmount);
        $result->append($method);

        return $result;
    }

    /**
     * Check whether a trigger-category item and a free-shipping-category item are present.
     *
     * @param array $items
     * @param array $triggerCategoryIds
     * @param array $freeShippingCategoryIds
     * @param int $storeId
     * @return bool
     */
    private function isPromoApplicable(
        array $items,
        array $triggerCategoryIds,
        array $freeShippingCategoryIds,
        int $storeId
    ): bool {
        if (!$this->promoHelper->isEnabled($storeId) || !$triggerCategoryIds || !$freeShippingCategoryIds) {
            return false;
        }

        $triggerFound = false;
        $freeShippingFound = false;
        foreach ($items as $item) {
            if ($this->promoHelper->matchesCategories($item, $triggerCategoryIds)) {
                $triggerFound = true;
            }
            if ($this->promoHelper->matchesCategories($item, $freeShippingCategoryIds)
                && !$this->promoHelper->matchesCategories($item, $triggerCategoryIds)
            ) {
                $freeShippingFound = true;
            }
        }

        return $triggerFound && $freeShippingFound;
    }

    /**
     * Resolve the nearest configured rate for a category or its ancestors.
     *
     * @param int $categoryId
     * @param int $storeId
     * @param array $configuredRates
     * @return array|null
     */
    private function getCategoryRate(int $categoryId, int $storeId, array $configuredRates): ?array
    {
        $category = $this->categoryRepository->get($categoryId, $storeId);
        $pathIds = array_map('intval', explode('/', (string)$category->getPath()));
        $categoryIds = array_reverse($pathIds);

        foreach ($categoryIds as $ancestorId) {
            $configured = $configuredRates[(string)$ancestorId] ?? [];
            if (!is_array($configured)) {
                continue;
            }

            $hasConfiguredRate = ($configured['first'] ?? '') !== ''
                || ($configured['second'] ?? '') !== '';
            if (!$hasConfiguredRate) {
                continue;
            }

            $first = max(0.0, (float)($configured['first'] ?? 0));
            $second = ($configured['second'] ?? '') !== ''
                ? max(0.0, (float)$configured['second'])
                : $first;

            return $first > 0.0 || $second > 0.0
                ? [
                    'first' => $first,
                    'second' => $second,
                    'source_id' => $ancestorId,
                    'source_path' => implode('/', array_slice(
                        $pathIds,
                        0,
                        array_search($ancestorId, $pathIds, true) + 1
                    )),
                ]
                : null;
        }

        $fallback = max(0.0, (float)$category->getData('shipping_cost'));
        return $fallback > 0.0
            ? [
                'first' => $fallback,
                'second' => $fallback,
                'source_id' => $categoryId,
                'source_path' => implode('/', $pathIds),
            ]
            : null;
    }

    /**
     * Remove ancestor rates when a more specific category rate is present.
     *
     * @param array $rates
     * @return array
     */
    private function removeAncestorRates(array $rates): array
    {
        foreach ($rates as $sourceId => $rate) {
            foreach ($rates as $otherSourceId => $otherRate) {
                if ($sourceId === $otherSourceId) {
                    continue;
                }

                $sourcePath = trim((string)($rate['source_path'] ?? ''), '/');
                $otherPath = trim((string)($otherRate['source_path'] ?? ''), '/');
                if ($sourcePath !== '' && $otherPath !== ''
                    && strpos($otherPath, $sourcePath . '/') === 0
                ) {
                    unset($rates[$sourceId]);
                    break;
                }
            }
        }

        return $rates;
    }

    /**
     * Return the available shipping method code and label.
     *
     * @return array
     */
    public function getAllowedMethods()
    {
        return ['category' => $this->getConfigData('name')];
    }
}
