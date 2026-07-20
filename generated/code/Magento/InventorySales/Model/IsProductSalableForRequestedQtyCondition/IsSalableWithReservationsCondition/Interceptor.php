<?php
namespace Magento\InventorySales\Model\IsProductSalableForRequestedQtyCondition\IsSalableWithReservationsCondition;

/**
 * Interceptor class for @see \Magento\InventorySales\Model\IsProductSalableForRequestedQtyCondition\IsSalableWithReservationsCondition
 */
class Interceptor extends \Magento\InventorySales\Model\IsProductSalableForRequestedQtyCondition\IsSalableWithReservationsCondition implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\InventorySalesApi\Model\GetStockItemDataInterface $getStockItemData, \Magento\InventorySalesApi\Api\Data\ProductSalabilityErrorInterfaceFactory $productSalabilityErrorFactory, \Magento\InventorySalesApi\Api\Data\ProductSalableResultInterfaceFactory $productSalableResultFactory, \Magento\InventorySalesApi\Model\GetSalableQtyInterface $getProductQtyInStock, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig)
    {
        $this->___init();
        parent::__construct($getStockItemData, $productSalabilityErrorFactory, $productSalableResultFactory, $getProductQtyInStock, $scopeConfig);
    }

    /**
     * {@inheritdoc}
     */
    public function execute(string $sku, int $stockId, float $requestedQty): \Magento\InventorySalesApi\Api\Data\ProductSalableResultInterface
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        return $pluginInfo ? $this->___callPlugins('execute', func_get_args(), $pluginInfo) : parent::execute($sku, $stockId, $requestedQty);
    }
}
