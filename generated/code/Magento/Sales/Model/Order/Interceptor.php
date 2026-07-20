<?php
namespace Magento\Sales\Model\Order;

/**
 * Interceptor class for @see \Magento\Sales\Model\Order
 */
class Interceptor extends \Magento\Sales\Model\Order implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Model\Context $context, \Magento\Framework\Registry $registry, \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory, \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory, \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Sales\Model\Order\Config $orderConfig, \Magento\Catalog\Api\ProductRepositoryInterface $productRepository, \Magento\Sales\Model\ResourceModel\Order\Item\CollectionFactory $orderItemCollectionFactory, \Magento\Catalog\Model\Product\Visibility $productVisibility, \Magento\Sales\Api\InvoiceManagementInterface $invoiceManagement, \Magento\Directory\Model\CurrencyFactory $currencyFactory, \Magento\Eav\Model\Config $eavConfig, \Magento\Sales\Model\Order\Status\HistoryFactory $orderHistoryFactory, \Magento\Sales\Model\ResourceModel\Order\Address\CollectionFactory $addressCollectionFactory, \Magento\Sales\Model\ResourceModel\Order\Payment\CollectionFactory $paymentCollectionFactory, \Magento\Sales\Model\ResourceModel\Order\Status\History\CollectionFactory $historyCollectionFactory, \Magento\Sales\Model\ResourceModel\Order\Invoice\CollectionFactory $invoiceCollectionFactory, \Magento\Sales\Model\ResourceModel\Order\Shipment\CollectionFactory $shipmentCollectionFactory, \Magento\Sales\Model\ResourceModel\Order\Creditmemo\CollectionFactory $memoCollectionFactory, \Magento\Sales\Model\ResourceModel\Order\Shipment\Track\CollectionFactory $trackCollectionFactory, \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $salesOrderCollectionFactory, \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency, \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productListFactory, ?\Magento\Framework\Model\ResourceModel\AbstractResource $resource = null, ?\Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null, array $data = [], ?\Magento\Framework\Locale\ResolverInterface $localeResolver = null, ?\Magento\Sales\Model\Order\ProductOption $productOption = null, ?\Magento\Sales\Api\OrderItemRepositoryInterface $itemRepository = null, ?\Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder = null, ?\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig = null, ?\Magento\Directory\Model\RegionFactory $regionFactory = null, ?\Magento\Directory\Model\ResourceModel\Region $regionResource = null, ?\Magento\Sales\Model\Order\StatusLabel $statusLabel = null, ?\Magento\Sales\Model\Order\CreditmemoValidator $creditmemoValidator = null)
    {
        $this->___init();
        parent::__construct($context, $registry, $extensionFactory, $customAttributeFactory, $timezone, $storeManager, $orderConfig, $productRepository, $orderItemCollectionFactory, $productVisibility, $invoiceManagement, $currencyFactory, $eavConfig, $orderHistoryFactory, $addressCollectionFactory, $paymentCollectionFactory, $historyCollectionFactory, $invoiceCollectionFactory, $shipmentCollectionFactory, $memoCollectionFactory, $trackCollectionFactory, $salesOrderCollectionFactory, $priceCurrency, $productListFactory, $resource, $resourceCollection, $data, $localeResolver, $productOption, $itemRepository, $searchCriteriaBuilder, $scopeConfig, $regionFactory, $regionResource, $statusLabel, $creditmemoValidator);
    }

    /**
     * {@inheritdoc}
     */
    public function canCancel()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'canCancel');
        return $pluginInfo ? $this->___callPlugins('canCancel', func_get_args(), $pluginInfo) : parent::canCancel();
    }

    /**
     * {@inheritdoc}
     */
    public function canVoidPayment()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'canVoidPayment');
        return $pluginInfo ? $this->___callPlugins('canVoidPayment', func_get_args(), $pluginInfo) : parent::canVoidPayment();
    }

    /**
     * {@inheritdoc}
     */
    public function canInvoice()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'canInvoice');
        return $pluginInfo ? $this->___callPlugins('canInvoice', func_get_args(), $pluginInfo) : parent::canInvoice();
    }

    /**
     * {@inheritdoc}
     */
    public function canCreditmemo()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'canCreditmemo');
        return $pluginInfo ? $this->___callPlugins('canCreditmemo', func_get_args(), $pluginInfo) : parent::canCreditmemo();
    }

    /**
     * {@inheritdoc}
     */
    public function canHold()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'canHold');
        return $pluginInfo ? $this->___callPlugins('canHold', func_get_args(), $pluginInfo) : parent::canHold();
    }

    /**
     * {@inheritdoc}
     */
    public function canShip()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'canShip');
        return $pluginInfo ? $this->___callPlugins('canShip', func_get_args(), $pluginInfo) : parent::canShip();
    }

    /**
     * {@inheritdoc}
     */
    public function canEdit()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'canEdit');
        return $pluginInfo ? $this->___callPlugins('canEdit', func_get_args(), $pluginInfo) : parent::canEdit();
    }

    /**
     * {@inheritdoc}
     */
    public function canReorder()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'canReorder');
        return $pluginInfo ? $this->___callPlugins('canReorder', func_get_args(), $pluginInfo) : parent::canReorder();
    }

    /**
     * {@inheritdoc}
     */
    public function canReorderIgnoreSalable()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'canReorderIgnoreSalable');
        return $pluginInfo ? $this->___callPlugins('canReorderIgnoreSalable', func_get_args(), $pluginInfo) : parent::canReorderIgnoreSalable();
    }

    /**
     * {@inheritdoc}
     */
    public function canReviewPayment()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'canReviewPayment');
        return $pluginInfo ? $this->___callPlugins('canReviewPayment', func_get_args(), $pluginInfo) : parent::canReviewPayment();
    }

    /**
     * {@inheritdoc}
     */
    public function canFetchPaymentReviewUpdate()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'canFetchPaymentReviewUpdate');
        return $pluginInfo ? $this->___callPlugins('canFetchPaymentReviewUpdate', func_get_args(), $pluginInfo) : parent::canFetchPaymentReviewUpdate();
    }

    /**
     * {@inheritdoc}
     */
    public function place()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'place');
        return $pluginInfo ? $this->___callPlugins('place', func_get_args(), $pluginInfo) : parent::place();
    }

    /**
     * {@inheritdoc}
     */
    public function cancel()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'cancel');
        return $pluginInfo ? $this->___callPlugins('cancel', func_get_args(), $pluginInfo) : parent::cancel();
    }

    /**
     * {@inheritdoc}
     */
    public function getRelatedObjects()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getRelatedObjects');
        return $pluginInfo ? $this->___callPlugins('getRelatedObjects', func_get_args(), $pluginInfo) : parent::getRelatedObjects();
    }

    /**
     * {@inheritdoc}
     */
    public function load($modelId, $field = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'load');
        return $pluginInfo ? $this->___callPlugins('load', func_get_args(), $pluginInfo) : parent::load($modelId, $field);
    }
}
