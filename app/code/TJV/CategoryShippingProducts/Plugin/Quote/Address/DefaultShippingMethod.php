<?php

namespace TJV\CategoryShippingProducts\Plugin\Quote\Address;

use Magento\Quote\Model\Quote\Address;

class DefaultShippingMethod
{
    /**
     * Keep the category method selected whenever it is available.
     *
     * @param Address $subject
     * @param Address $result
     * @return Address
     */
    public function afterCollectShippingRates(Address $subject, Address $result): Address
    {
        if (!$result->getCountryId()) {
            return $result;
        }

        foreach ($result->getAllShippingRates() as $rate) {
            if ($rate->getCode() !== 'tjv_category_category') {
                continue;
            }

            $baseAmount = (float)$rate->getPrice();
            $store = $result->getQuote()->getStore();
            $shippingAmount = $store->getBaseCurrency()->convert(
                $baseAmount,
                $store->getCurrentCurrencyCode()
            );
            $result->setShippingMethod($rate->getCode());
            $result->setShippingDescription($rate->getMethodTitle());
            $result->setBaseShippingAmount($baseAmount);
            $result->setShippingAmount((float)$shippingAmount);
            break;
        }

        return $result;
    }
}
