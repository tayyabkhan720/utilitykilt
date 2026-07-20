<?php
namespace Magento\PaymentServicesPaypal\Block\Adminhtml\Form\PayLaterStyleConfig;

/**
 * Interceptor class for @see \Magento\PaymentServicesPaypal\Block\Adminhtml\Form\PayLaterStyleConfig
 */
class Interceptor extends \Magento\PaymentServicesPaypal\Block\Adminhtml\Form\PayLaterStyleConfig implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Magento\PaymentServicesBase\Model\MerchantService $merchantService, \Magento\PaymentServicesPaypal\Model\PaypalMerchantResolver $paypalMerchantResolver, \Magento\Framework\App\Cache\Type\Config $configCache, \Psr\Log\LoggerInterface $logger, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $merchantService, $paypalMerchantResolver, $configCache, $logger, $data);
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
