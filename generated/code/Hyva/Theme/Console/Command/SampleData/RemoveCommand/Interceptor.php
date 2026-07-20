<?php
namespace Hyva\Theme\Console\Command\SampleData\RemoveCommand;

/**
 * Interceptor class for @see \Hyva\Theme\Console\Command\SampleData\RemoveCommand
 */
class Interceptor extends \Hyva\Theme\Console\Command\SampleData\RemoveCommand implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Filesystem $filesystem, \Magento\Framework\Composer\ComposerInformation $composerInformation)
    {
        $this->___init();
        parent::__construct($filesystem, $composerInformation);
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
