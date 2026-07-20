<?php
namespace MageWorx\OptionBase\Api\Data;

/**
 * ExtensionInterface class for @see \MageWorx\OptionBase\Api\Data\ProductCustomOptionValuesInterface
 */
interface ProductCustomOptionValuesExtensionInterface extends \Magento\Framework\Api\ExtensionAttributesInterface
{
    /**
     * @return string|null
     */
    public function getMageworxTitle();

    /**
     * @param string $mageworxTitle
     * @return $this
     */
    public function setMageworxTitle($mageworxTitle);

    /**
     * @return string|null
     */
    public function getMageworxOptionTypePrice();

    /**
     * @param string $mageworxOptionTypePrice
     * @return $this
     */
    public function setMageworxOptionTypePrice($mageworxOptionTypePrice);

    /**
     * @return string|null
     */
    public function getSpecialPrice();

    /**
     * @param string $specialPrice
     * @return $this
     */
    public function setSpecialPrice($specialPrice);

    /**
     * @return string|null
     */
    public function getTierPrice();

    /**
     * @param string $tierPrice
     * @return $this
     */
    public function setTierPrice($tierPrice);

    /**
     * @return string|null
     */
    public function getDependency();

    /**
     * @param string $dependency
     * @return $this
     */
    public function setDependency($dependency);

    /**
     * @return string|null
     */
    public function getDependencyType();

    /**
     * @param string $dependencyType
     * @return $this
     */
    public function setDependencyType($dependencyType);

    /**
     * @return string|null
     */
    public function getOptionTypeTitleId();

    /**
     * @param string $optionTypeTitleId
     * @return $this
     */
    public function setOptionTypeTitleId($optionTypeTitleId);

    /**
     * @return float|null
     */
    public function getCost();

    /**
     * @param float $cost
     * @return $this
     */
    public function setCost($cost);

    /**
     * @return string|null
     */
    public function getDescription();

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description);

    /**
     * @return string|null
     */
    public function getImagesData();

    /**
     * @param string $imagesData
     * @return $this
     */
    public function setImagesData($imagesData);

    /**
     * @return boolean|null
     */
    public function getIsDefault();

    /**
     * @param boolean $isDefault
     * @return $this
     */
    public function setIsDefault($isDefault);

    /**
     * @return boolean|null
     */
    public function getLoadLinkedProduct();

    /**
     * @param boolean $loadLinkedProduct
     * @return $this
     */
    public function setLoadLinkedProduct($loadLinkedProduct);

    /**
     * @return int|null
     */
    public function getQtyMultiplier();

    /**
     * @param int $qtyMultiplier
     * @return $this
     */
    public function setQtyMultiplier($qtyMultiplier);

    /**
     * @return float|null
     */
    public function getWeight();

    /**
     * @param float $weight
     * @return $this
     */
    public function setWeight($weight);

    /**
     * @return string|null
     */
    public function getWeightType();

    /**
     * @param string $weightType
     * @return $this
     */
    public function setWeightType($weightType);

    /**
     * @return boolean|null
     */
    public function getManageStock();

    /**
     * @param boolean $manageStock
     * @return $this
     */
    public function setManageStock($manageStock);

    /**
     * @return float|null
     */
    public function getQty();

    /**
     * @param float $qty
     * @return $this
     */
    public function setQty($qty);

    /**
     * @return boolean|null
     */
    public function getDisabled();

    /**
     * @param boolean $disabled
     * @return $this
     */
    public function setDisabled($disabled);
}
