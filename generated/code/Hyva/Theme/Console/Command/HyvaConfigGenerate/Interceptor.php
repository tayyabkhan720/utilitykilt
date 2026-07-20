<?php
namespace Hyva\Theme\Console\Command\HyvaConfigGenerate;

/**
 * Interceptor class for @see \Hyva\Theme\Console\Command\HyvaConfigGenerate
 */
class Interceptor extends \Hyva\Theme\Console\Command\HyvaConfigGenerate implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Hyva\Theme\Model\HyvaModulesConfig $hyvaModulesConfig)
    {
        $this->___init();
        parent::__construct($hyvaModulesConfig);
    }

    /**
     * {@inheritdoc}
     */
    public function run(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output): int
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'run');
        return $pluginInfo ? $this->___callPlugins('run', func_get_args(), $pluginInfo) : parent::run($input, $output);
    }
}
