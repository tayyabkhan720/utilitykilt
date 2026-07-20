<?php
namespace Magento\Catalog\Api\Data;

/**
 * ExtensionInterface class for @see \Magento\Catalog\Api\Data\ProductCustomOptionInterface
 */
interface ProductCustomOptionExtensionInterface extends \Magento\Framework\Api\ExtensionAttributesInterface
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
    public function getMageworxOptionPrice();

    /**
     * @param string $mageworxOptionPrice
     * @return $this
     */
    public function setMageworxOptionPrice($mageworxOptionPrice);

    /**
     * @return string|null
     */
    public function getOptionTitleId();

    /**
     * @param string $optionTitleId
     * @return $this
     */
    public function setOptionTitleId($optionTitleId);

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
    public function getDependencyRules();

    /**
     * @param string $dependencyRules
     * @return $this
     */
    public function setDependencyRules($dependencyRules);

    /**
     * @return string|null
     */
    public function getHiddenDependents();

    /**
     * @param string $hiddenDependents
     * @return $this
     */
    public function setHiddenDependents($hiddenDependents);

    /**
     * @return string[]|null
     */
    public function getDependency();

    /**
     * @param string[] $dependency
     * @return $this
     */
    public function setDependency($dependency);

    /**
     * @return boolean|null
     */
    public function getQtyInput();

    /**
     * @param boolean $qtyInput
     * @return $this
     */
    public function setQtyInput($qtyInput);

    /**
     * @return boolean|null
     */
    public function getOneTime();

    /**
     * @param boolean $oneTime
     * @return $this
     */
    public function setOneTime($oneTime);

    /**
     * @return string|null
     */
    public function getDivClass();

    /**
     * @param string $divClass
     * @return $this
     */
    public function setDivClass($divClass);

    /**
     * @return int|null
     */
    public function getMageworxOptionImageMode();

    /**
     * @param int $mageworxOptionImageMode
     * @return $this
     */
    public function setMageworxOptionImageMode($mageworxOptionImageMode);

    /**
     * @return int|null
     */
    public function getSelectionLimitFrom();

    /**
     * @param int $selectionLimitFrom
     * @return $this
     */
    public function setSelectionLimitFrom($selectionLimitFrom);

    /**
     * @return int|null
     */
    public function getSelectionLimitTo();

    /**
     * @param int $selectionLimitTo
     * @return $this
     */
    public function setSelectionLimitTo($selectionLimitTo);

    /**
     * @return boolean|null
     */
    public function getIsHidden();

    /**
     * @param boolean $isHidden
     * @return $this
     */
    public function setIsHidden($isHidden);

    /**
     * @return string|null
     */
    public function getShareableLink();

    /**
     * @param string $shareableLink
     * @return $this
     */
    public function setShareableLink($shareableLink);

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
    public function getOptionValueDescription();

    /**
     * @param string $optionValueDescription
     * @return $this
     */
    public function setOptionValueDescription($optionValueDescription);

    /**
     * @return int|null
     */
    public function getIsDefault();

    /**
     * @param int $isDefault
     * @return $this
     */
    public function setIsDefault($isDefault);

    /**
     * @return int|null
     */
    public function getMageworxOptionGallery();

    /**
     * @param int $mageworxOptionGallery
     * @return $this
     */
    public function setMageworxOptionGallery($mageworxOptionGallery);

    /**
     * @return int|null
     */
    public function getGroupOptionId();

    /**
     * @param int $groupOptionId
     * @return $this
     */
    public function setGroupOptionId($groupOptionId);

    /**
     * @return string|null
     */
    public function getSkuPolicy();

    /**
     * @param string $skuPolicy
     * @return $this
     */
    public function setSkuPolicy($skuPolicy);

    /**
     * @return int|null
     */
    public function getIsSwatch();

    /**
     * @param int $isSwatch
     * @return $this
     */
    public function setIsSwatch($isSwatch);

    /**
     * @return boolean|null
     */
    public function getIsAllGroups();

    /**
     * @param boolean $isAllGroups
     * @return $this
     */
    public function setIsAllGroups($isAllGroups);

    /**
     * @return boolean|null
     */
    public function getIsAllWebsites();

    /**
     * @param boolean $isAllWebsites
     * @return $this
     */
    public function setIsAllWebsites($isAllWebsites);

    /**
     * @return boolean|null
     */
    public function getDisabled();

    /**
     * @param boolean $disabled
     * @return $this
     */
    public function setDisabled($disabled);

    /**
     * @return boolean|null
     */
    public function getDisabledByValues();

    /**
     * @param boolean $disabledByValues
     * @return $this
     */
    public function setDisabledByValues($disabledByValues);
}
