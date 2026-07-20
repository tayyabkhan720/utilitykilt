<?php

declare(strict_types=1);

namespace TJV\HyvaMageworxSwatches\ViewModel;

use Magento\Catalog\Model\Product\Option;
use Magento\Catalog\Api\Data\ProductCustomOptionValuesInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\Pricing\Helper\Data as PricingHelper;
use MageWorx\OptionFeatures\Helper\Data as OptionFeaturesHelper;
use MageWorx\OptionBase\Helper\Price as BasePriceHelper;
use MageWorx\OptionFeatures\Model\Price as AdvancedPricingPrice;
use Magento\Framework\Pricing\PriceCurrencyInterface;

class MageworxSwatch implements ArgumentInterface
{
    /**
     * @var OptionFeaturesHelper
     */
    private $helper;

    /**
     * @var BasePriceHelper
     */
    private $basePriceHelper;

    /**
     * @var AdvancedPricingPrice
     */
    private $advancedPricingPrice;

    /**
     * @var PricingHelper
     */
    private $pricingHelper;

    private PriceCurrencyInterface $priceCurrency;

    public function __construct(
        OptionFeaturesHelper $helper,
        BasePriceHelper $basePriceHelper,
        AdvancedPricingPrice $advancedPricingPrice,
        PricingHelper $pricingHelper,
        PriceCurrencyInterface $priceCurrency

    ) {
        $this->helper = $helper;
        $this->basePriceHelper = $basePriceHelper;
        $this->advancedPricingPrice = $advancedPricingPrice;
        $this->pricingHelper = $pricingHelper;
        $this->priceCurrency = $priceCurrency;
    }

    /**
     * @param Option $option
     * @return bool
     */
    public function isSwatchOption($option): bool
    {
        return (bool) $option->getIsSwatch()
            && ($option->getType() === Option::OPTION_TYPE_DROP_DOWN
                || $option->getType() === Option::OPTION_TYPE_MULTIPLE
                || $option->getType() === Option::OPTION_TYPE_RADIO
                || $option->getType() === Option::OPTION_TYPE_CHECKBOX);
    }

    /**
     * @param ProductCustomOptionValuesInterface $value
     * @return string 'text'|'image'|'color'
     */
    public function getSwatchType($value): string
    {
        return $value->getBaseImageType() ?: 'text';
    }

    /**
     * @param ProductCustomOptionValuesInterface $value
     * @return string|null
     */
    public function getSwatchImageUrl($value): ?string
    {
        $url = $this->helper->getThumbImageUrl(
            $value->getBaseImage(),
            OptionFeaturesHelper::IMAGE_MEDIA_ATTRIBUTE_SWATCH_IMAGE
        );

        return $url ?: null;
    }

    /**
     * @return int
     */
    public function getSwatchWidth(): int
    {
        return (int) $this->helper->getSwatchWidth();
    }

    /**
     * @return int
     */
    public function getSwatchHeight(): int
    {
        return (int) $this->helper->getSwatchHeight();
    }

    /**
     * @return int
     */
    public function getTextSwatchMaxWidth(): int
    {
        return (int) $this->helper->getTextSwatchMaxWidth();
    }

    /**
     * @return bool
     */
    public function isShowSwatchTitle(): bool
    {
        return (bool) $this->helper->isShowSwatchTitle();
    }

    /**
     * @return bool
     */
    public function isShowSwatchPrice(): bool
    {
        return (bool) $this->helper->isShowSwatchPrice();
    }

    /**
     * @param Option $option
     * @param ProductCustomOptionValuesInterface $value
     * @param \Magento\Catalog\Model\Product $product
     * @return float
     */
    public function getSwatchValuePrice($option, $value, $product): float
    {
        if (!$value->getPrice()) {
            return 0.0;
        }

        $price = $this->advancedPricingPrice->getPrice($option, $value);
        $excludeTax = $this->basePriceHelper->isPriceDisplayModeExcludeTax();

        return (float) $this->basePriceHelper->getTaxPrice($product, $price, !$excludeTax);
    }

    /**
     * @param float $price
     * @param \Magento\Store\Api\Data\StoreInterface $store
     * @return string
     */
    public function formatPrice(float $price, $store): string
    {
        return $this->priceCurrency->convertAndFormat($price, false, PriceCurrencyInterface::DEFAULT_PRECISION, $store);
    }
}