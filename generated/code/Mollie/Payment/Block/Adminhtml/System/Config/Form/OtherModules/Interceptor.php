<?php
namespace Mollie\Payment\Block\Adminhtml\System\Config\Form\OtherModules;

/**
 * Interceptor class for @see \Mollie\Payment\Block\Adminhtml\System\Config\Form\OtherModules
 */
class Interceptor extends \Mollie\Payment\Block\Adminhtml\System\Config\Form\OtherModules implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Magento\Framework\Module\ModuleListInterface $moduleList, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $moduleList, $data);
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
