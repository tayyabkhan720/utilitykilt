<?php
namespace Magento\Framework\View\Design\Fallback\Rule\ModularSwitch;

/**
 * Interceptor class for @see \Magento\Framework\View\Design\Fallback\Rule\ModularSwitch
 */
class Interceptor extends \Magento\Framework\View\Design\Fallback\Rule\ModularSwitch implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Design\Fallback\Rule\RuleInterface $ruleNonModular, \Magento\Framework\View\Design\Fallback\Rule\RuleInterface $ruleModular)
    {
        $this->___init();
        parent::__construct($ruleNonModular, $ruleModular);
    }

    /**
     * {@inheritdoc}
     */
    public function getPatternDirs(array $params)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getPatternDirs');
        return $pluginInfo ? $this->___callPlugins('getPatternDirs', func_get_args(), $pluginInfo) : parent::getPatternDirs($params);
    }
}
