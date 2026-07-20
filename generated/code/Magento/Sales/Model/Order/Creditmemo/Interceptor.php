<?php
namespace Magento\Sales\Model\Order\Creditmemo;

/**
 * Interceptor class for @see \Magento\Sales\Model\Order\Creditmemo
 */
class Interceptor extends \Magento\Sales\Model\Order\Creditmemo implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Model\Context $context, \Magento\Framework\Registry $registry, \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory, \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory, \Magento\Sales\Model\Order\Creditmemo\Config $creditmemoConfig, \Magento\Sales\Model\OrderFactory $orderFactory, \Magento\Sales\Model\ResourceModel\Order\Creditmemo\Item\CollectionFactory $cmItemCollectionFactory, \Magento\Framework\Math\CalculatorFactory $calculatorFactory, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Sales\Model\Order\Creditmemo\CommentFactory $commentFactory, \Magento\Sales\Model\ResourceModel\Order\Creditmemo\Comment\CollectionFactory $commentCollectionFactory, \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency, ?\Magento\Framework\Model\ResourceModel\AbstractResource $resource = null, ?\Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null, array $data = [], ?\Magento\Sales\Model\Order\InvoiceFactory $invoiceFactory = null, ?\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig = null, ?\Magento\Sales\Api\OrderRepositoryInterface $orderRepository = null)
    {
        $this->___init();
        parent::__construct($context, $registry, $extensionFactory, $customAttributeFactory, $creditmemoConfig, $orderFactory, $cmItemCollectionFactory, $calculatorFactory, $storeManager, $commentFactory, $commentCollectionFactory, $priceCurrency, $resource, $resourceCollection, $data, $invoiceFactory, $scopeConfig, $orderRepository);
    }

    /**
     * {@inheritdoc}
     */
    public function canRefund()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'canRefund');
        return $pluginInfo ? $this->___callPlugins('canRefund', func_get_args(), $pluginInfo) : parent::canRefund();
    }
}
