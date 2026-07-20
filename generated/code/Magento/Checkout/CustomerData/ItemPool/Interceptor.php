<?php
namespace Magento\Checkout\CustomerData\ItemPool;

/**
 * Interceptor class for @see \Magento\Checkout\CustomerData\ItemPool
 */
class Interceptor extends \Magento\Checkout\CustomerData\ItemPool implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $defaultItemId, array $itemMap = [])
    {
        $this->___init();
        parent::__construct($objectManager, $defaultItemId, $itemMap);
    }

    /**
     * {@inheritdoc}
     */
    public function getItemData(\Magento\Quote\Model\Quote\Item $item)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getItemData');
        return $pluginInfo ? $this->___callPlugins('getItemData', func_get_args(), $pluginInfo) : parent::getItemData($item);
    }
}
