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

class Category extends AbstractCarrier implements CarrierInterface
{
    protected $_code = 'tjv_category';

    private ResultFactory $rateResultFactory;
    private MethodFactory $rateMethodFactory;
    private CategoryRepository $categoryRepository;
    private PriceCurrencyInterface $priceCurrency;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory,
        LoggerInterface $logger,
        ResultFactory $rateResultFactory,
        MethodFactory $rateMethodFactory,
        CategoryRepository $categoryRepository,
        PriceCurrencyInterface $priceCurrency,
        array $data = []
    ) {
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
        $this->rateResultFactory = $rateResultFactory;
        $this->rateMethodFactory = $rateMethodFactory;
        $this->categoryRepository = $categoryRepository;
        $this->priceCurrency = $priceCurrency;
    }

    public function collectRates(RateRequest $request)
    {
        if (!$this->getConfigFlag('active') || !$request->getAllItems()) {
            return false;
        }

        $categoryIds = [];
        foreach ($request->getAllItems() as $item) {
            if ($item->getParentItem() || $item->getProduct()->isVirtual()) {
                continue;
            }

            $categoryIds = array_merge($categoryIds, $item->getProduct()->getCategoryIds());
        }

        $categoryIds = array_unique(array_map('intval', $categoryIds));
        $baseAmount = 0.0;
        foreach ($categoryIds as $categoryId) {
            try {
                $category = $this->categoryRepository->get($categoryId, (int)$request->getStoreId());
                $baseAmount += max(0.0, (float)$category->getData('shipping_cost'));
            } catch (\Magento\Framework\Exception\NoSuchEntityException $exception) {
                $this->_logger->warning(
                    'Unable to load category for category shipping rate.',
                    ['category_id' => $categoryId, 'exception' => $exception]
                );
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
}
