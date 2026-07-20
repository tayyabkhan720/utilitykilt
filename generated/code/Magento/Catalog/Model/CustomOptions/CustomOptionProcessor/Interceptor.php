<?php
namespace Magento\Catalog\Model\CustomOptions\CustomOptionProcessor;

/**
 * Interceptor class for @see \Magento\Catalog\Model\CustomOptions\CustomOptionProcessor
 */
class Interceptor extends \Magento\Catalog\Model\CustomOptions\CustomOptionProcessor implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\DataObject\Factory $objectFactory, \Magento\Quote\Model\Quote\ProductOptionFactory $productOptionFactory, \Magento\Quote\Api\Data\ProductOptionExtensionFactory $extensionFactory, \Magento\Catalog\Model\CustomOptions\CustomOptionFactory $customOptionFactory, ?\Magento\Framework\Serialize\Serializer\Json $serializer = null)
    {
        $this->___init();
        parent::__construct($objectFactory, $productOptionFactory, $extensionFactory, $customOptionFactory, $serializer);
    }

    /**
     * {@inheritdoc}
     */
    public function convertToBuyRequest(\Magento\Quote\Api\Data\CartItemInterface $cartItem)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'convertToBuyRequest');
        return $pluginInfo ? $this->___callPlugins('convertToBuyRequest', func_get_args(), $pluginInfo) : parent::convertToBuyRequest($cartItem);
    }
}
