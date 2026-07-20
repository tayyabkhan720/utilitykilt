<?php
namespace Magewirephp\Magewire\Model\ComponentManager;

/**
 * Interceptor class for @see \Magewirephp\Magewire\Model\ComponentManager
 */
class Interceptor extends \Magewirephp\Magewire\Model\ComponentManager implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magewirephp\Magewire\Model\Context\Hydrator $hydratorContext, \Magento\Framework\Locale\Resolver $localeResolver, \Magewirephp\Magewire\Model\HttpFactory $httpFactory, array $updateActionsPool = [], array $hydrationPool = [])
    {
        $this->___init();
        parent::__construct($hydratorContext, $localeResolver, $httpFactory, $updateActionsPool, $hydrationPool);
    }

    /**
     * {@inheritdoc}
     */
    public function hydrate(\Magewirephp\Magewire\Component $component): \Magewirephp\Magewire\Component
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'hydrate');
        return $pluginInfo ? $this->___callPlugins('hydrate', func_get_args(), $pluginInfo) : parent::hydrate($component);
    }
}
