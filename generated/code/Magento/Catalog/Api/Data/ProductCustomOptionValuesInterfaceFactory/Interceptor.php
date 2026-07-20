<?php
namespace Magento\Catalog\Api\Data\ProductCustomOptionValuesInterfaceFactory;

/**
 * Interceptor class for @see \Magento\Catalog\Api\Data\ProductCustomOptionValuesInterfaceFactory
 */
class Interceptor extends \Magento\Catalog\Api\Data\ProductCustomOptionValuesInterfaceFactory implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\Magento\\Catalog\\Api\\Data\\ProductCustomOptionValuesInterface')
    {
        $this->___init();
        parent::__construct($objectManager, $instanceName);
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data = [])
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'create');
        return $pluginInfo ? $this->___callPlugins('create', func_get_args(), $pluginInfo) : parent::create($data);
    }
}
