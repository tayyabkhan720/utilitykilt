<?php
namespace Magento\Catalog\Api\Data;

/**
 * Extension class for @see \Magento\Catalog\Api\Data\ProductCustomOptionInterface
 */
class ProductCustomOptionExtension extends \Magento\Framework\Api\AbstractSimpleObject implements ProductCustomOptionExtensionInterface
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
    public function getMageworxOptionPrice()
    {
        return $this->_get('mageworx_option_price');
    }

    /**
     * @param string $mageworxOptionPrice
     * @return $this
     */
    public function setMageworxOptionPrice($mageworxOptionPrice)
    {
        $this->setData('mageworx_option_price', $mageworxOptionPrice);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOptionTitleId()
    {
        return $this->_get('option_title_id');
    }

    /**
     * @param string $optionTitleId
     * @return $this
     */
    public function setOptionTitleId($optionTitleId)
    {
        $this->setData('option_title_id', $optionTitleId);
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
    public function getDependencyRules()
    {
        return $this->_get('dependency_rules');
    }

    /**
     * @param string $dependencyRules
     * @return $this
     */
    public function setDependencyRules($dependencyRules)
    {
        $this->setData('dependency_rules', $dependencyRules);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHiddenDependents()
    {
        return $this->_get('hidden_dependents');
    }

    /**
     * @param string $hiddenDependents
     * @return $this
     */
    public function setHiddenDependents($hiddenDependents)
    {
        $this->setData('hidden_dependents', $hiddenDependents);
        return $this;
    }

    /**
     * @return string[]|null
     */
    public function getDependency()
    {
        return $this->_get('dependency');
    }

    /**
     * @param string[] $dependency
     * @return $this
     */
    public function setDependency($dependency)
    {
        $this->setData('dependency', $dependency);
        return $this;
    }

    /**
     * @return boolean|null
     */
    public function getQtyInput()
    {
        return $this->_get('qty_input');
    }

    /**
     * @param boolean $qtyInput
     * @return $this
     */
    public function setQtyInput($qtyInput)
    {
        $this->setData('qty_input', $qtyInput);
        return $this;
    }

    /**
     * @return boolean|null
     */
    public function getOneTime()
    {
        return $this->_get('one_time');
    }

    /**
     * @param boolean $oneTime
     * @return $this
     */
    public function setOneTime($oneTime)
    {
        $this->setData('one_time', $oneTime);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDivClass()
    {
        return $this->_get('div_class');
    }

    /**
     * @param string $divClass
     * @return $this
     */
    public function setDivClass($divClass)
    {
        $this->setData('div_class', $divClass);
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMageworxOptionImageMode()
    {
        return $this->_get('mageworx_option_image_mode');
    }

    /**
     * @param int $mageworxOptionImageMode
     * @return $this
     */
    public function setMageworxOptionImageMode($mageworxOptionImageMode)
    {
        $this->setData('mageworx_option_image_mode', $mageworxOptionImageMode);
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSelectionLimitFrom()
    {
        return $this->_get('selection_limit_from');
    }

    /**
     * @param int $selectionLimitFrom
     * @return $this
     */
    public function setSelectionLimitFrom($selectionLimitFrom)
    {
        $this->setData('selection_limit_from', $selectionLimitFrom);
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSelectionLimitTo()
    {
        return $this->_get('selection_limit_to');
    }

    /**
     * @param int $selectionLimitTo
     * @return $this
     */
    public function setSelectionLimitTo($selectionLimitTo)
    {
        $this->setData('selection_limit_to', $selectionLimitTo);
        return $this;
    }

    /**
     * @return boolean|null
     */
    public function getIsHidden()
    {
        return $this->_get('is_hidden');
    }

    /**
     * @param boolean $isHidden
     * @return $this
     */
    public function setIsHidden($isHidden)
    {
        $this->setData('is_hidden', $isHidden);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getShareableLink()
    {
        return $this->_get('shareable_link');
    }

    /**
     * @param string $shareableLink
     * @return $this
     */
    public function setShareableLink($shareableLink)
    {
        $this->setData('shareable_link', $shareableLink);
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
    public function getOptionValueDescription()
    {
        return $this->_get('option_value_description');
    }

    /**
     * @param string $optionValueDescription
     * @return $this
     */
    public function setOptionValueDescription($optionValueDescription)
    {
        $this->setData('option_value_description', $optionValueDescription);
        return $this;
    }

    /**
     * @return int|null
     */
    public function getIsDefault()
    {
        return $this->_get('is_default');
    }

    /**
     * @param int $isDefault
     * @return $this
     */
    public function setIsDefault($isDefault)
    {
        $this->setData('is_default', $isDefault);
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMageworxOptionGallery()
    {
        return $this->_get('mageworx_option_gallery');
    }

    /**
     * @param int $mageworxOptionGallery
     * @return $this
     */
    public function setMageworxOptionGallery($mageworxOptionGallery)
    {
        $this->setData('mageworx_option_gallery', $mageworxOptionGallery);
        return $this;
    }

    /**
     * @return int|null
     */
    public function getGroupOptionId()
    {
        return $this->_get('group_option_id');
    }

    /**
     * @param int $groupOptionId
     * @return $this
     */
    public function setGroupOptionId($groupOptionId)
    {
        $this->setData('group_option_id', $groupOptionId);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSkuPolicy()
    {
        return $this->_get('sku_policy');
    }

    /**
     * @param string $skuPolicy
     * @return $this
     */
    public function setSkuPolicy($skuPolicy)
    {
        $this->setData('sku_policy', $skuPolicy);
        return $this;
    }

    /**
     * @return int|null
     */
    public function getIsSwatch()
    {
        return $this->_get('is_swatch');
    }

    /**
     * @param int $isSwatch
     * @return $this
     */
    public function setIsSwatch($isSwatch)
    {
        $this->setData('is_swatch', $isSwatch);
        return $this;
    }

    /**
     * @return boolean|null
     */
    public function getIsAllGroups()
    {
        return $this->_get('is_all_groups');
    }

    /**
     * @param boolean $isAllGroups
     * @return $this
     */
    public function setIsAllGroups($isAllGroups)
    {
        $this->setData('is_all_groups', $isAllGroups);
        return $this;
    }

    /**
     * @return boolean|null
     */
    public function getIsAllWebsites()
    {
        return $this->_get('is_all_websites');
    }

    /**
     * @param boolean $isAllWebsites
     * @return $this
     */
    public function setIsAllWebsites($isAllWebsites)
    {
        $this->setData('is_all_websites', $isAllWebsites);
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

    /**
     * @return boolean|null
     */
    public function getDisabledByValues()
    {
        return $this->_get('disabled_by_values');
    }

    /**
     * @param boolean $disabledByValues
     * @return $this
     */
    public function setDisabledByValues($disabledByValues)
    {
        $this->setData('disabled_by_values', $disabledByValues);
        return $this;
    }
}
