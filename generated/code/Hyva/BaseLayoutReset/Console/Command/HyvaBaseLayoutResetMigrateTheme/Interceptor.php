<?php
namespace Hyva\BaseLayoutReset\Console\Command\HyvaBaseLayoutResetMigrateTheme;

/**
 * Interceptor class for @see \Hyva\BaseLayoutReset\Console\Command\HyvaBaseLayoutResetMigrateTheme
 */
class Interceptor extends \Hyva\BaseLayoutReset\Console\Command\HyvaBaseLayoutResetMigrateTheme implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Hyva\BaseLayoutReset\Model\MigrateThemeToGeneratedBaseLayout $migrateThemeToGeneratedBaseLayout)
    {
        $this->___init();
        parent::__construct($migrateThemeToGeneratedBaseLayout);
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
