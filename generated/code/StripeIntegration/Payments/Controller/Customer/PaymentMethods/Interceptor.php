<?php
namespace StripeIntegration\Payments\Controller\Customer\PaymentMethods;

/**
 * Interceptor class for @see \StripeIntegration\Payments\Controller\Customer\PaymentMethods
 */
class Interceptor extends \StripeIntegration\Payments\Controller\Customer\PaymentMethods implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\StripeIntegration\Payments\Helper\Generic $helper, \StripeIntegration\Payments\Helper\Url $urlHelper, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Customer\Model\Session $session, \Magento\Framework\App\RequestInterface $request)
    {
        $this->___init();
        parent::__construct($helper, $urlHelper, $resultPageFactory, $session, $request);
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
