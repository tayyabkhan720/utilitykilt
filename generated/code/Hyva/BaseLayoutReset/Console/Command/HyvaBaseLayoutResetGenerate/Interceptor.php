<?php
namespace Hyva\BaseLayoutReset\Console\Command\HyvaBaseLayoutResetGenerate;

/**
 * Interceptor class for @see \Hyva\BaseLayoutReset\Console\Command\HyvaBaseLayoutResetGenerate
 */
class Interceptor extends \Hyva\BaseLayoutReset\Console\Command\HyvaBaseLayoutResetGenerate implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\File\CollectorInterface $baseLayoutFilesCollector, \Magento\Framework\View\File\CollectorInterface $basePageLayoutFilesCollector, \Magento\Theme\Model\Theme\DataFactory $themeFactory, \Hyva\BaseLayoutReset\Model\Layout\LayoutFileReset $layoutFileReset)
    {
        $this->___init();
        parent::__construct($baseLayoutFilesCollector, $basePageLayoutFilesCollector, $themeFactory, $layoutFileReset);
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
