<?php
namespace Magento\ImportExport\Model\ResourceModel\Import\Data;

/**
 * Interceptor class for @see \Magento\ImportExport\Model\ResourceModel\Import\Data
 */
class Interceptor extends \Magento\ImportExport\Model\ResourceModel\Import\Data implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Model\ResourceModel\Db\Context $context, \Magento\Framework\Json\Helper\Data $jsonHelper, $connectionName = null)
    {
        $this->___init();
        parent::__construct($context, $jsonHelper, $connectionName);
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
