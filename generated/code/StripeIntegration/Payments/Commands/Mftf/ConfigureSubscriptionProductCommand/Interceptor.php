<?php
namespace StripeIntegration\Payments\Commands\Mftf\ConfigureSubscriptionProductCommand;

/**
 * Interceptor class for @see \StripeIntegration\Payments\Commands\Mftf\ConfigureSubscriptionProductCommand
 */
class Interceptor extends \StripeIntegration\Payments\Commands\Mftf\ConfigureSubscriptionProductCommand implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\StripeIntegration\Payments\Helper\AreaCodeFactory $areaCodeFactory, \StripeIntegration\Payments\Model\SubscriptionOptionsFactory $subscriptionOptionsFactory, \StripeIntegration\Payments\Model\ResourceModel\SubscriptionOptionsFactory $subscriptionOptionsResourceModelFactory)
    {
        $this->___init();
        parent::__construct($areaCodeFactory, $subscriptionOptionsFactory, $subscriptionOptionsResourceModelFactory);
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
