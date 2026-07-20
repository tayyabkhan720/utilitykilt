<?php
namespace Magento\PaymentServicesPaypal\Model\Adminhtml\Source\PaypalMerchant;

/**
 * Interceptor class for @see \Magento\PaymentServicesPaypal\Model\Adminhtml\Source\PaypalMerchant
 */
class Interceptor extends \Magento\PaymentServicesPaypal\Model\Adminhtml\Source\PaypalMerchant implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\PaymentServicesPaypal\Model\PaypalMerchantResolver $paypalMerchantResolver, \Magento\Backend\Block\Template\Context $context, array $data = [])
    {
        $this->___init();
        parent::__construct($paypalMerchantResolver, $context, $data);
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
