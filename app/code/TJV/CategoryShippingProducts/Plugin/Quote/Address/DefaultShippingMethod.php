<?php

namespace TJV\CategoryShippingProducts\Plugin\Quote\Address;

use Magento\Quote\Model\Quote\Address;

class DefaultShippingMethod
{
    public function afterCollectShippingRates(Address $subject, Address $result): Address
    {
        if ($result->getShippingMethod() || !$result->getCountryId()) {
            return $result;
        }

        foreach ($result->getAllShippingRates() as $rate) {
            if ($rate->getCode() !== 'tjv_category_category') {
                continue;
            }

            $amount = (float)$rate->getPrice();
            $result->setShippingMethod($rate->getCode());
            $result->setShippingDescription($rate->getMethodTitle());
            $result->setBaseShippingAmount($amount);
            $result->setShippingAmount($amount);
            break;
        }

        return $result;
    }
}
