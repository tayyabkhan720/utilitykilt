<?php
namespace Magento\Checkout\CustomerData\DirectoryData;

/**
 * Interceptor class for @see \Magento\Checkout\CustomerData\DirectoryData
 */
class Interceptor extends \Magento\Checkout\CustomerData\DirectoryData implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Directory\Helper\Data $directoryHelper)
    {
        $this->___init();
        parent::__construct($directoryHelper);
    }

    /**
     * {@inheritdoc}
     */
    public function getSectionData()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSectionData');
        return $pluginInfo ? $this->___callPlugins('getSectionData', func_get_args(), $pluginInfo) : parent::getSectionData();
    }
}
