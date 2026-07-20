<?php
namespace Amasty\CheckoutCore\Block\Adminhtml\Field\Edit\Group;

/**
 * Interceptor class for @see \Amasty\CheckoutCore\Block\Adminhtml\Field\Edit\Group
 */
class Interceptor extends \Amasty\CheckoutCore\Block\Adminhtml\Field\Edit\Group implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Data\Form\Element\Factory $factoryElement, \Magento\Framework\Data\Form\Element\CollectionFactory $factoryCollection, \Magento\Framework\Escaper $escaper, \Amasty\CheckoutCore\Block\Adminhtml\Field\Edit\Group\RowFactory $rowFactory, array $data = [])
    {
        $this->___init();
        parent::__construct($factoryElement, $factoryCollection, $escaper, $rowFactory, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function addField($elementId, $type, $config, $after = false, $isAdvanced = false)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addField');
        return $pluginInfo ? $this->___callPlugins('addField', func_get_args(), $pluginInfo) : parent::addField($elementId, $type, $config, $after, $isAdvanced);
    }
}
