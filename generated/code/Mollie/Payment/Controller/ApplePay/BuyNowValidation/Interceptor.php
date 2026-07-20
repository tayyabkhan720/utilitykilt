<?php
namespace Mollie\Payment\Controller\ApplePay\BuyNowValidation;

/**
 * Interceptor class for @see \Mollie\Payment\Controller\ApplePay\BuyNowValidation
 */
class Interceptor extends \Mollie\Payment\Controller\ApplePay\BuyNowValidation implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Customer\Model\Session $customerSession, \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository, \Magento\Customer\Api\AccountManagementInterface $accountManagement, \Mollie\Payment\Config $config, \Magento\Framework\Locale\ResolverInterface $resolver, \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator, \Magento\Quote\Api\GuestCartManagementInterface $cartManagement, \Magento\Quote\Api\GuestCartRepositoryInterface $guestCartRepository, \Magento\Quote\Api\CartRepositoryInterface $cartRepository, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Catalog\Api\ProductRepositoryInterface $productRepository, \Mollie\Payment\Service\Mollie\MollieApiClient $mollieApiClient, \Magento\Framework\UrlInterface $url, \Laminas\Uri\Http $uri)
    {
        $this->___init();
        parent::__construct($context, $customerSession, $customerRepository, $accountManagement, $config, $resolver, $formKeyValidator, $cartManagement, $guestCartRepository, $cartRepository, $storeManager, $productRepository, $mollieApiClient, $url, $uri);
    }

    /**
     * {@inheritdoc}
     */
    public function execute(): \Magento\Framework\Controller\ResultInterface
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        return $pluginInfo ? $this->___callPlugins('execute', func_get_args(), $pluginInfo) : parent::execute();
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(\Magento\Framework\App\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'dispatch');
        return $pluginInfo ? $this->___callPlugins('dispatch', func_get_args(), $pluginInfo) : parent::dispatch($request);
    }
}
