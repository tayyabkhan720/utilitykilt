<?php

namespace TJV\CategoryShippingProducts\Model\Carrier;

use Magento\Catalog\Model\CategoryRepository;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Quote\Model\Quote\Address\RateResult\MethodFactory;
use Magento\Shipping\Model\Carrier\AbstractCarrier;
use Magento\Shipping\Model\Carrier\CarrierInterface;
use Magento\Shipping\Model\Rate\Result;
use Magento\Shipping\Model\Rate\ResultFactory;
use Psr\Log\LoggerInterface;
use TJV\CategoryShippingProducts\Helper\Config as CategoryShippingConfig;

class Category extends AbstractCarrier implements CarrierInterface
{
    protected $_code = 'tjv_category';

    private ResultFactory $rateResultFactory;
    private MethodFactory $rateMethodFactory;
    private CategoryRepository $categoryRepository;
    private PriceCurrencyInterface $priceCurrency;
    private CategoryShippingConfig $categoryShippingConfig;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory,
        LoggerInterface $logger,
        ResultFactory $rateResultFactory,
        MethodFactory $rateMethodFactory,
        CategoryRepository $categoryRepository,
        PriceCurrencyInterface $priceCurrency,
        CategoryShippingConfig $categoryShippingConfig,
        array $data = []
    ) {
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
        $this->rateResultFactory = $rateResultFactory;
        $this->rateMethodFactory = $rateMethodFactory;
        $this->categoryRepository = $categoryRepository;
        $this->priceCurrency = $priceCurrency;
        $this->categoryShippingConfig = $categoryShippingConfig;
    }

    public function collectRates(RateRequest $request)
    {
        if ($this->getConfigData('active') === '0' || !$request->getAllItems()) {
            return false;
        }

        $categoryIds = [];
        foreach ($request->getAllItems() as $item) {
            if ($item->getParentItem() || $item->getProduct()->isVirtual() || $item->getFreeShipping()) {
                continue;
            }

            $categoryIds[] = [
                'ids' => $item->getProduct()->getCategoryIds(),
                'qty' => max(1, (int)$item->getQty()),
            ];
        }

        $categoryRates = [];
        $configuredRates = $this->categoryShippingConfig->getRates(
            (int)$request->getStoreId(),
            (string)$request->getDestCountryId()
        );
        foreach ($categoryIds as $itemCategories) {
            $itemRateSources = [];
            foreach (array_unique(array_map('intval', $itemCategories['ids'])) as $categoryId) {
                try {
                    $rate = $this->getCategoryRate(
                        $categoryId,
                        (int)$request->getStoreId(),
                        $configuredRates
                    );
                    if ($rate !== null) {
                        $itemRateSources[(int)$rate['source_id']] = $rate;
                    }
                } catch (\Magento\Framework\Exception\NoSuchEntityException $exception) {
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

        $store = $request->getStore();
        $amount = $store ? $this->priceCurrency->convert($baseAmount, $store) : $baseAmount;
        /** @var Result $result */
        $result = $this->rateResultFactory->create();
        $method = $this->rateMethodFactory->create();
        $method->setCarrier($this->_code);
        $method->setCarrierTitle((string)$this->getConfigData('title'));
        $method->setMethod('category');
        $method->setMethodTitle((string)$this->getConfigData('name'));
        $method->setPrice($amount);
        $method->setCost($amount);
        $result->append($method);

        return $result;
    }

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

    public function getAllowedMethods()
    {
        return ['category' => $this->getConfigData('name')];
    }
}
