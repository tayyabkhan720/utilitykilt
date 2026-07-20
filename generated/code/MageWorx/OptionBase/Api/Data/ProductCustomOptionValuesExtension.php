<?php
namespace MageWorx\OptionBase\Api\Data;

/**
 * Extension class for @see \MageWorx\OptionBase\Api\Data\ProductCustomOptionValuesInterface
 */
class ProductCustomOptionValuesExtension extends \Magento\Framework\Api\AbstractSimpleObject implements ProductCustomOptionValuesExtensionInterface
{
    /**
     * @return string|null
     */
    public function getMageworxTitle()
    {
        return $this->_get('mageworx_title');
    }

    /**
     * @param string $mageworxTitle
     * @return $this
     */
    public function setMageworxTitle($mageworxTitle)
    {
        $this->setData('mageworx_title', $mageworxTitle);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMageworxOptionTypePrice()
    {
        return $this->_get('mageworx_option_type_price');
    }

    /**
     * @param string $mageworxOptionTypePrice
     * @return $this
     */
    public function setMageworxOptionTypePrice($mageworxOptionTypePrice)
    {
        $this->setData('mageworx_option_type_price', $mageworxOptionTypePrice);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSpecialPrice()
    {
        return $this->_get('special_price');
    }

    /**
     * @param string $specialPrice
     * @return $this
     */
    public function setSpecialPrice($specialPrice)
    {
        $this->setData('special_price', $specialPrice);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTierPrice()
    {
        return $this->_get('tier_price');
    }

    /**
     * @param string $tierPrice
     * @return $this
     */
    public function setTierPrice($tierPrice)
    {
        $this->setData('tier_price', $tierPrice);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDependency()
    {
        return $this->_get('dependency');
    }

    /**
     * @param string $dependency
     * @return $this
     */
    public function setDependency($dependency)
    {
        $this->setData('dependency', $dependency);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDependencyType()
    {
        return $this->_get('dependency_type');
    }

    /**
     * @param string $dependencyType
     * @return $this
     */
    public function setDependencyType($dependencyType)
    {
        $this->setData('dependency_type', $dependencyType);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOptionTypeTitleId()
    {
        return $this->_get('option_type_title_id');
    }

    /**
     * @param string $optionTypeTitleId
     * @return $this
     */
    public function setOptionTypeTitleId($optionTypeTitleId)
    {
        $this->setData('option_type_title_id', $optionTypeTitleId);
        return $this;
    }

    /**
     * @return float|null
     */
    public function getCost()
    {
        return $this->_get('cost');
    }

    /**
     * @param float $cost
     * @return $this
     */
    public function setCost($cost)
    {
        $this->setData('cost', $cost);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription()
    {
        return $this->_get('description');
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->setData('description', $description);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getImagesData()
    {
        return $this->_get('images_data');
    }

    /**
     * @param string $imagesData
     * @return $this
     */
    public function setImagesData($imagesData)
    {
        $this->setData('images_data', $imagesData);
        return $this;
    }

    /**
     * @return boolean|null
     */
    public function getIsDefault()
    {
        return $this->_get('is_default');
    }

    /**
     * @param boolean $isDefault
     * @return $this
     */
    public function setIsDefault($isDefault)
    {
        $this->setData('is_default', $isDefault);
        return $this;
    }

    /**
     * @return boolean|null
     */
    public function getLoadLinkedProduct()
    {
        return $this->_get('load_linked_product');
    }

    /**
     * @param boolean $loadLinkedProduct
     * @return $this
     */
    public function setLoadLinkedProduct($loadLinkedProduct)
    {
        $this->setData('load_linked_product', $loadLinkedProduct);
        return $this;
    }

    /**
     * @return int|null
     */
    public function getQtyMultiplier()
    {
        return $this->_get('qty_multiplier');
    }

    /**
     * @param int $qtyMultiplier
     * @return $this
     */
    public function setQtyMultiplier($qtyMultiplier)
    {
        $this->setData('qty_multiplier', $qtyMultiplier);
        return $this;
    }

    /**
     * @return float|null
     */
    public function getWeight()
    {
        return $this->_get('weight');
    }

    /**
     * @param float $weight
     * @return $this
     */
    public function setWeight($weight)
    {
        $this->setData('weight', $weight);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getWeightType()
    {
        return $this->_get('weight_type');
    }

    /**
     * @param string $weightType
     * @return $this
     */
    public function setWeightType($weightType)
    {
        $this->setData('weight_type', $weightType);
        return $this;
    }

    /**
     * @return boolean|null
     */
    public function getManageStock()
    {
        return $this->_get('manage_stock');
    }

    /**
     * @param boolean $manageStock
     * @return $this
     */
    public function setManageStock($manageStock)
    {
        $this->setData('manage_stock', $manageStock);
        return $this;
    }

    /**
     * @return float|null
     */
    public function getQty()
    {
        return $this->_get('qty');
    }

    /**
     * @param float $qty
     * @return $this
     */
    public function setQty($qty)
    {
        $this->setData('qty', $qty);
        return $this;
    }

    /**
     * @return boolean|null
     */
    public function getDisabled()
    {
        return $this->_get('disabled');
    }

    /**
     * @param boolean $disabled
     * @return $this
     */
    public function setDisabled($disabled)
    {
        $this->setData('disabled', $disabled);
        return $this;
    }
}
