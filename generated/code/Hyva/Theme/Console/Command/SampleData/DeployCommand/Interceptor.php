<?php
namespace Hyva\Theme\Console\Command\SampleData\DeployCommand;

/**
 * Interceptor class for @see \Hyva\Theme\Console\Command\SampleData\DeployCommand
 */
class Interceptor extends \Hyva\Theme\Console\Command\SampleData\DeployCommand implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Filesystem $filesystem, \Magento\Framework\ObjectManagerInterface $objectManager, \Magento\Framework\Composer\ComposerInformation $composerInformation, \Magento\Framework\Composer\ComposerFactory $composerFactory, \Magento\Framework\App\ResourceConnection $resourceConnection, \Magento\Framework\App\Cache\Manager $cacheManager)
    {
        $this->___init();
        parent::__construct($filesystem, $objectManager, $composerInformation, $composerFactory, $resourceConnection, $cacheManager);
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
