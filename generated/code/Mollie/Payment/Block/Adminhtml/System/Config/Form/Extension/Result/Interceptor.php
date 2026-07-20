<?php
namespace Mollie\Payment\Block\Adminhtml\System\Config\Form\Extension\Result;

/**
 * Interceptor class for @see \Mollie\Payment\Block\Adminhtml\System\Config\Form\Extension\Result
 */
class Interceptor extends \Mollie\Payment\Block\Adminhtml\System\Config\Form\Extension\Result implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element): string
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'render');
        return $pluginInfo ? $this->___callPlugins('render', func_get_args(), $pluginInfo) : parent::render($element);
    }
}
