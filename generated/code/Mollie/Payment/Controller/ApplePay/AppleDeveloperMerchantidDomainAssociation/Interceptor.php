<?php
namespace Mollie\Payment\Controller\ApplePay\AppleDeveloperMerchantidDomainAssociation;

/**
 * Interceptor class for @see \Mollie\Payment\Controller\ApplePay\AppleDeveloperMerchantidDomainAssociation
 */
class Interceptor extends \Mollie\Payment\Controller\ApplePay\AppleDeveloperMerchantidDomainAssociation implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Mollie\Payment\Config $config, \Magento\Framework\Controller\ResultFactory $resultFactory, \Magento\Framework\Filesystem\Driver\File $driverFile, \Magento\Framework\Module\Dir $moduleDir, \Mollie\Payment\Service\Mollie\ApplePay\Certificate $certificate)
    {
        $this->___init();
        parent::__construct($config, $resultFactory, $driverFile, $moduleDir, $certificate);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        return $pluginInfo ? $this->___callPlugins('execute', func_get_args(), $pluginInfo) : parent::execute();
    }
}
