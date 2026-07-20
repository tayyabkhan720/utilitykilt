<?php
namespace Magento\Sales\Model\Service\CreditmemoService;

/**
 * Interceptor class for @see \Magento\Sales\Model\Service\CreditmemoService
 */
class Interceptor extends \Magento\Sales\Model\Service\CreditmemoService implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Sales\Api\CreditmemoRepositoryInterface $creditmemoRepository, \Magento\Sales\Api\CreditmemoCommentRepositoryInterface $creditmemoCommentRepository, \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder, \Magento\Framework\Api\FilterBuilder $filterBuilder, \Magento\Sales\Model\Order\CreditmemoNotifier $creditmemoNotifier, \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency, \Magento\Framework\Event\ManagerInterface $eventManager)
    {
        $this->___init();
        parent::__construct($creditmemoRepository, $creditmemoCommentRepository, $searchCriteriaBuilder, $filterBuilder, $creditmemoNotifier, $priceCurrency, $eventManager);
    }

    /**
     * {@inheritdoc}
     */
    public function refund(\Magento\Sales\Api\Data\CreditmemoInterface $creditmemo, $offlineRequested = false)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'refund');
        return $pluginInfo ? $this->___callPlugins('refund', func_get_args(), $pluginInfo) : parent::refund($creditmemo, $offlineRequested);
    }
}
