<?php

namespace TJV\ShippingCost\Model\Carrier;

use Magento\Catalog\Model\CategoryRepository;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Shipping\Model\Carrier\AbstractCarrier;
use Magento\Shipping\Model\Carrier\CarrierInterface;
use Magento\Shipping\Model\Rate\Result;
use Magento\Shipping\Model\Rate\ResultFactory;
use Magento\Quote\Model\Quote\Address\RateResult\MethodFactory;
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
        CategoryShippingConfig|array $categoryShippingConfig = [],
        array $data = []
    ) {
        if (is_array($categoryShippingConfig)) {
            $data = $categoryShippingConfig;
            $categoryShippingConfig = $this->resolveCategoryShippingConfig();
        }
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
        $this->rateResultFactory = $rateResultFactory;
        $this->rateMethodFactory = $rateMethodFactory;
        $this->categoryRepository = $categoryRepository;
        $this->priceCurrency = $priceCurrency;
        $this->categoryShippingConfig = $categoryShippingConfig;
    }

    private function resolveCategoryShippingConfig(): CategoryShippingConfig
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        return $objectManager->get(CategoryShippingConfig::class);
    }

    public function collectRates(RateRequest $request)
    {
        $active = $this->getConfigData('active');
        if ($active === '0' || !$request->getAllItems()) {
            return false;
        }

        $triggerProducts = $this->getConfiguredProducts(
            'tjv_promo/buy_one_free_shipping/trigger_product_ids'
        );
        $freeShippingProducts = $this->getConfiguredProducts(
            'tjv_promo/buy_one_free_shipping/free_shipping_product_ids'
        );
        $promoApplies = $this->_scopeConfig->isSetFlag(
            'tjv_promo/buy_one_free_shipping/enabled'
        )
            && $triggerProducts
            && $freeShippingProducts
            && $this->hasMatchingItem($request->getAllItems(), $triggerProducts);

        $categoryIds = [];
        foreach ($request->getAllItems() as $item) {
            if ($item->getParentItem()
                || $item->getProduct()->isVirtual()
                || $item->getFreeShipping()
                || ($promoApplies && $this->matchesConfiguredProduct($item, $freeShippingProducts))
            ) {
                continue;
            }

            $categoryIds = array_merge($categoryIds, $item->getProduct()->getCategoryIds());
        }

        $categoryIds = array_unique(array_map('intval', $categoryIds));
        $categoryRates = [];
        $configuredRates = $this->categoryShippingConfig->getRates((int)$request->getStoreId());
        foreach ($categoryIds as $categoryId) {
            try {
                $category = $this->categoryRepository->get($categoryId, (int)$request->getStoreId());
                $fallback = max(0.0, (float)$category->getData('shipping_cost'));
                $configured = $configuredRates[(string)$categoryId] ?? [];
                $first = isset($configured['first']) && $configured['first'] !== ''
                    ? max(0.0, (float)$configured['first'])
                    : $fallback;
                $second = isset($configured['second']) && $configured['second'] !== ''
                    ? max(0.0, (float)$configured['second'])
                    : $first;
                if ($first > 0.0 || $second > 0.0) {
                    $categoryRates[] = ['first' => $first, 'second' => $second];
                }
            } catch (\Magento\Framework\Exception\NoSuchEntityException $exception) {
                $this->_logger->warning(
                    'Unable to load category for category shipping rate.',
                    ['category_id' => $categoryId, 'exception' => $exception]
                );
            }
        }

        usort($categoryRates, static function (array $left, array $right): int {
            return $right['first'] <=> $left['first'];
        });

        $baseAmount = 0.0;
        if ($categoryRates) {
            $baseAmount = $categoryRates[0]['first'];
            foreach (array_slice($categoryRates, 1) as $categoryRate) {
                $baseAmount += $categoryRate['second'];
            }
        }

        if ($baseAmount <= 0.0) {
            return false;
        }

        $store = $request->getStore();
        $amount = $store
            ? $this->priceCurrency->convert($baseAmount, $store)
            : $baseAmount;

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

    public function getAllowedMethods()
    {
        return ['category' => $this->getConfigData('name')];
    }

    private function hasMatchingItem(array $items, array $configuredProducts): bool
    {
        foreach ($items as $item) {
            if ($this->matchesConfiguredProduct($item, $configuredProducts)) {
                return true;
            }
        }

        return false;
    }

    private function matchesConfiguredProduct($item, array $configuredProducts): bool
    {
        if (in_array((string)$item->getProductId(), $configuredProducts, true)) {
            return true;
        }

        $itemSku = (string)$item->getSku();
        $productSku = (string)$item->getProduct()->getSku();
        foreach ($configuredProducts as $configuredProduct) {
            if ($itemSku === $configuredProduct
                || $productSku === $configuredProduct
                || ($itemSku !== '' && strpos($itemSku, $configuredProduct . '-') === 0)
                || ($productSku !== '' && strpos($productSku, $configuredProduct . '-') === 0)
            ) {
                return true;
            }
        }

        return false;
    }

    private function getConfiguredProducts(string $path): array
    {
        $value = $this->_scopeConfig->getValue($path);
        if (!$value) {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode(',', (string)$value))));
    }
}
