<?php
namespace Magento\Framework\Webapi\ServiceInputProcessor;

/**
 * Interceptor class for @see \Magento\Framework\Webapi\ServiceInputProcessor
 */
class Interceptor extends \Magento\Framework\Webapi\ServiceInputProcessor implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Reflection\TypeProcessor $typeProcessor, \Magento\Framework\ObjectManagerInterface $objectManager, \Magento\Framework\Api\AttributeValueFactory $attributeValueFactory, \Magento\Framework\Webapi\CustomAttributeTypeLocatorInterface $customAttributeTypeLocator, \Magento\Framework\Reflection\MethodsMap $methodsMap, ?\Magento\Framework\Webapi\ServiceTypeToEntityTypeMap $serviceTypeToEntityTypeMap = null, ?\Magento\Framework\ObjectManager\ConfigInterface $config = null, array $customAttributePreprocessors = [], ?\Magento\Framework\Webapi\Validator\ServiceInputValidatorInterface $serviceInputValidator = null, int $defaultPageSize = 20, ?\Magento\Framework\Webapi\Validator\IOLimit\DefaultPageSizeSetter $defaultPageSizeSetter = null)
    {
        $this->___init();
        parent::__construct($typeProcessor, $objectManager, $attributeValueFactory, $customAttributeTypeLocator, $methodsMap, $serviceTypeToEntityTypeMap, $config, $customAttributePreprocessors, $serviceInputValidator, $defaultPageSize, $defaultPageSizeSetter);
    }

    /**
     * {@inheritdoc}
     */
    public function convertValue($data, $type)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'convertValue');
        return $pluginInfo ? $this->___callPlugins('convertValue', func_get_args(), $pluginInfo) : parent::convertValue($data, $type);
    }
}
