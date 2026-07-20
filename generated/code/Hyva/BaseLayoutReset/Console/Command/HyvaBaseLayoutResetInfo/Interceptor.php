<?php
namespace Hyva\BaseLayoutReset\Console\Command\HyvaBaseLayoutResetInfo;

/**
 * Interceptor class for @see \Hyva\BaseLayoutReset\Console\Command\HyvaBaseLayoutResetInfo
 */
class Interceptor extends \Hyva\BaseLayoutReset\Console\Command\HyvaBaseLayoutResetInfo implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Hyva\BaseLayoutReset\Model\HyvaThemeResetInfo $hyvaThemeResetInfo, \Hyva\Theme\Service\HyvaThemes $hyvaThemes)
    {
        $this->___init();
        parent::__construct($hyvaThemeResetInfo, $hyvaThemes);
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
