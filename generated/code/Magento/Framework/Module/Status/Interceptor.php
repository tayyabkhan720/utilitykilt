<?php
namespace Magento\Framework\Module\Status;

/**
 * Interceptor class for @see \Magento\Framework\Module\Status
 */
class Interceptor extends \Magento\Framework\Module\Status implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Module\ModuleList\Loader $loader, \Magento\Framework\Module\ModuleList $list, \Magento\Framework\App\DeploymentConfig\Writer $writer, \Magento\Framework\Module\ConflictChecker $conflictChecker, \Magento\Framework\Module\DependencyChecker $dependencyChecker)
    {
        $this->___init();
        parent::__construct($loader, $list, $writer, $conflictChecker, $dependencyChecker);
    }

    /**
     * {@inheritdoc}
     */
    public function setIsEnabled($isEnabled, $modules)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setIsEnabled');
        return $pluginInfo ? $this->___callPlugins('setIsEnabled', func_get_args(), $pluginInfo) : parent::setIsEnabled($isEnabled, $modules);
    }
}
