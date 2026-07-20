<?php
namespace StripeIntegration\Payments\Commands\Orders\MigratePaymentMethodCommand;

/**
 * Interceptor class for @see \StripeIntegration\Payments\Commands\Orders\MigratePaymentMethodCommand
 */
class Interceptor extends \StripeIntegration\Payments\Commands\Orders\MigratePaymentMethodCommand implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\StripeIntegration\Payments\Helper\MigrateFactory $migrateFactory)
    {
        $this->___init();
        parent::__construct($migrateFactory);
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
