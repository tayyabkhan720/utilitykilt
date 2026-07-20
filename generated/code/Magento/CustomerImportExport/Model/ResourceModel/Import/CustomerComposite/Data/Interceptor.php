<?php
namespace Magento\CustomerImportExport\Model\ResourceModel\Import\CustomerComposite\Data;

/**
 * Interceptor class for @see \Magento\CustomerImportExport\Model\ResourceModel\Import\CustomerComposite\Data
 */
class Interceptor extends \Magento\CustomerImportExport\Model\ResourceModel\Import\CustomerComposite\Data implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Model\ResourceModel\Db\Context $context, \Magento\Framework\Json\Helper\Data $jsonHelper, $connectionName = null, array $arguments = [])
    {
        $this->___init();
        parent::__construct($context, $jsonHelper, $connectionName, $arguments);
    }

    /**
     * {@inheritdoc}
     */
    public function getNextBunch()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getNextBunch');
        return $pluginInfo ? $this->___callPlugins('getNextBunch', func_get_args(), $pluginInfo) : parent::getNextBunch();
    }
}
