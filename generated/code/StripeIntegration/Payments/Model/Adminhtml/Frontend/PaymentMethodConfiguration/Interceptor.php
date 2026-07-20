<?php
namespace StripeIntegration\Payments\Model\Adminhtml\Frontend\PaymentMethodConfiguration;

/**
 * Interceptor class for @see \StripeIntegration\Payments\Model\Adminhtml\Frontend\PaymentMethodConfiguration
 */
class Interceptor extends \StripeIntegration\Payments\Model\Adminhtml\Frontend\PaymentMethodConfiguration implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\StripeIntegration\Payments\Model\Adminhtml\Source\PaymentMethodConfiguration $paymentMethodSourceModel, \Magento\Backend\Block\Template\Context $context, array $data = [])
    {
        $this->___init();
        parent::__construct($paymentMethodSourceModel, $context, $data);
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
