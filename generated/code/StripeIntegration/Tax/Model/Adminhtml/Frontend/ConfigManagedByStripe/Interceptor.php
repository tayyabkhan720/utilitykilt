<?php
namespace StripeIntegration\Tax\Model\Adminhtml\Frontend\ConfigManagedByStripe;

/**
 * Interceptor class for @see \StripeIntegration\Tax\Model\Adminhtml\Frontend\ConfigManagedByStripe
 */
class Interceptor extends \StripeIntegration\Tax\Model\Adminhtml\Frontend\ConfigManagedByStripe implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\StripeIntegration\Tax\Model\StripeTax $stripeTax, \Magento\Backend\Block\Template\Context $context, array $data = [])
    {
        $this->___init();
        parent::__construct($stripeTax, $context, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'render');
        return $pluginInfo ? $this->___callPlugins('render', func_get_args(), $pluginInfo) : parent::render($element);
    }
}
