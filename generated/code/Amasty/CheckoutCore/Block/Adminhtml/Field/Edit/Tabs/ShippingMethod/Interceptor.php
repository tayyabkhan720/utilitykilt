<?php
namespace Amasty\CheckoutCore\Block\Adminhtml\Field\Edit\Tabs\ShippingMethod;

/**
 * Interceptor class for @see \Amasty\CheckoutCore\Block\Adminhtml\Field\Edit\Tabs\ShippingMethod
 */
class Interceptor extends \Amasty\CheckoutCore\Block\Adminhtml\Field\Edit\Tabs\ShippingMethod implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Magento\Framework\Registry $registry, \Magento\Framework\Data\FormFactory $formFactory, \Amasty\CheckoutCore\Block\Adminhtml\Field\Edit\Group $groupRows, \Amasty\CheckoutCore\Model\FormManagement $formManagement, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $registry, $formFactory, $groupRows, $formManagement, $data);
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
