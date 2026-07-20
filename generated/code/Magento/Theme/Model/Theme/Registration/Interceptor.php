<?php
namespace Magento\Theme\Model\Theme\Registration;

/**
 * Interceptor class for @see \Magento\Theme\Model\Theme\Registration
 */
class Interceptor extends \Magento\Theme\Model\Theme\Registration implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Theme\Model\ResourceModel\Theme\Data\CollectionFactory $collectionFactory, \Magento\Theme\Model\Theme\Data\Collection $filesystemCollection)
    {
        $this->___init();
        parent::__construct($collectionFactory, $filesystemCollection);
    }

    /**
     * {@inheritdoc}
     */
    public function checkPhysicalThemes()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'checkPhysicalThemes');
        return $pluginInfo ? $this->___callPlugins('checkPhysicalThemes', func_get_args(), $pluginInfo) : parent::checkPhysicalThemes();
    }
}
