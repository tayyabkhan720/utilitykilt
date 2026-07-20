<?php
namespace StripeIntegration\Payments\Commands\Subscriptions\CreateFromOrderCommand;

/**
 * Interceptor class for @see \StripeIntegration\Payments\Commands\Subscriptions\CreateFromOrderCommand
 */
class Interceptor extends \StripeIntegration\Payments\Commands\Subscriptions\CreateFromOrderCommand implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Sales\Api\OrderRepositoryInterface $orderRepository, \Magento\Sales\Api\Data\OrderInterfaceFactory $orderFactory, \StripeIntegration\Payments\Helper\AreaCodeFactory $areaCodeFactory, \StripeIntegration\Payments\Model\StripeCustomerFactory $stripeCustomerFactory, \StripeIntegration\Payments\Model\ConfigFactory $configFactory, \StripeIntegration\Payments\Helper\SubscriptionsFactory $subscriptionsHelperFactory)
    {
        $this->___init();
        parent::__construct($orderRepository, $orderFactory, $areaCodeFactory, $stripeCustomerFactory, $configFactory, $subscriptionsHelperFactory);
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
