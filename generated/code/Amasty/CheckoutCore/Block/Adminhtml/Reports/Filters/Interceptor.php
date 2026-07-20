<?php
namespace Amasty\CheckoutCore\Block\Adminhtml\Reports\Filters;

/**
 * Interceptor class for @see \Amasty\CheckoutCore\Block\Adminhtml\Reports\Filters
 */
class Interceptor extends \Amasty\CheckoutCore\Block\Adminhtml\Reports\Filters implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Magento\Framework\Registry $registry, \Magento\Framework\Data\FormFactory $formFactory, \Magento\Customer\Api\GroupRepositoryInterface $groupRepository, \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder, \Magento\Framework\Convert\DataObject $objectConverter, \Amasty\CheckoutCore\Model\Date $date, \Amasty\CheckoutCore\Model\ItemManagement $itemManagement, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $registry, $formFactory, $groupRepository, $searchCriteriaBuilder, $objectConverter, $date, $itemManagement, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getForm()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getForm');
        return $pluginInfo ? $this->___callPlugins('getForm', func_get_args(), $pluginInfo) : parent::getForm();
    }
}
