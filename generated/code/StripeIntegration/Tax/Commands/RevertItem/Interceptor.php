<?php
namespace StripeIntegration\Tax\Commands\RevertItem;

/**
 * Interceptor class for @see \StripeIntegration\Tax\Commands\RevertItem
 */
class Interceptor extends \StripeIntegration\Tax\Commands\RevertItem implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Sales\Model\ResourceModel\Order $orderResource, \Magento\Sales\Model\OrderFactory $orderFactory, \StripeIntegration\Tax\Helper\Order $orderHelper, \StripeIntegration\Tax\Helper\LineItemsFactory $lineItemsHelperFactory, \StripeIntegration\Tax\Model\ResourceModel\Transaction\LineItem\CollectionFactory $lineItemsCollectionFactory, \StripeIntegration\Tax\Model\StripeTransactionReversalFactory $reversalFactory, \StripeIntegration\Tax\Helper\Currency $currencyHelper)
    {
        $this->___init();
        parent::__construct($orderResource, $orderFactory, $orderHelper, $lineItemsHelperFactory, $lineItemsCollectionFactory, $reversalFactory, $currencyHelper);
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
