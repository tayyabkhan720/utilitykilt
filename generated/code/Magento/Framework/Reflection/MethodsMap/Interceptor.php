<?php
namespace Magento\Framework\Reflection\MethodsMap;

/**
 * Interceptor class for @see \Magento\Framework\Reflection\MethodsMap
 */
class Interceptor extends \Magento\Framework\Reflection\MethodsMap implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Cache\FrontendInterface $cache, \Magento\Framework\Reflection\TypeProcessor $typeProcessor, \Magento\Framework\Api\AttributeTypeResolverInterface $typeResolver, \Magento\Framework\Reflection\FieldNamer $fieldNamer)
    {
        $this->___init();
        parent::__construct($cache, $typeProcessor, $typeResolver, $fieldNamer);
    }

    /**
     * {@inheritdoc}
     */
    public function getMethodsMap($interfaceName)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getMethodsMap');
        return $pluginInfo ? $this->___callPlugins('getMethodsMap', func_get_args(), $pluginInfo) : parent::getMethodsMap($interfaceName);
    }
}
