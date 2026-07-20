<?php
namespace Magento\Tax\Model\Calculation\UnitBaseCalculator;

/**
 * Interceptor class for @see \Magento\Tax\Model\Calculation\UnitBaseCalculator
 */
class Interceptor extends \Magento\Tax\Model\Calculation\UnitBaseCalculator implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Tax\Api\TaxClassManagementInterface $taxClassService, \Magento\Tax\Api\Data\TaxDetailsItemInterfaceFactory $taxDetailsItemDataObjectFactory, \Magento\Tax\Api\Data\AppliedTaxInterfaceFactory $appliedTaxDataObjectFactory, \Magento\Tax\Api\Data\AppliedTaxRateInterfaceFactory $appliedTaxRateDataObjectFactory, \Magento\Tax\Model\Calculation $calculationTool, \Magento\Tax\Model\Config $config, $storeId, ?\Magento\Framework\DataObject $addressRateRequest = null)
    {
        $this->___init();
        parent::__construct($taxClassService, $taxDetailsItemDataObjectFactory, $appliedTaxDataObjectFactory, $appliedTaxRateDataObjectFactory, $calculationTool, $config, $storeId, $addressRateRequest);
    }

    /**
     * {@inheritdoc}
     */
    public function calculate(\Magento\Tax\Api\Data\QuoteDetailsItemInterface $item, $quantity, $round = true)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'calculate');
        return $pluginInfo ? $this->___callPlugins('calculate', func_get_args(), $pluginInfo) : parent::calculate($item, $quantity, $round);
    }
}
