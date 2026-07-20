<?php
namespace Magento\Catalog\Model\Product\Option\Type\File;

/**
 * Interceptor class for @see \Magento\Catalog\Model\Product\Option\Type\File
 */
class Interceptor extends \Magento\Catalog\Model\Product\Option\Type\File implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Checkout\Model\Session $checkoutSession, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Quote\Model\Quote\Item\OptionFactory $itemOptionFactory, \Magento\MediaStorage\Helper\File\Storage\Database $coreFileStorageDatabase, \Magento\Catalog\Model\Product\Option\Type\File\ValidatorInfo $validatorInfo, \Magento\Catalog\Model\Product\Option\Type\File\ValidatorFile $validatorFile, \Magento\Catalog\Model\Product\Option\UrlBuilder $urlBuilder, \Magento\Framework\Escaper $escaper, array $data = [], ?\Magento\Framework\Filesystem $filesystem = null, ?\Magento\Framework\Serialize\Serializer\Json $serializer = null, ?\Magento\Catalog\Helper\Product $productHelper = null)
    {
        $this->___init();
        parent::__construct($checkoutSession, $scopeConfig, $itemOptionFactory, $coreFileStorageDatabase, $validatorInfo, $validatorFile, $urlBuilder, $escaper, $data, $filesystem, $serializer, $productHelper);
    }

    /**
     * {@inheritdoc}
     */
    public function validateUserValue($values)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'validateUserValue');
        return $pluginInfo ? $this->___callPlugins('validateUserValue', func_get_args(), $pluginInfo) : parent::validateUserValue($values);
    }
}
