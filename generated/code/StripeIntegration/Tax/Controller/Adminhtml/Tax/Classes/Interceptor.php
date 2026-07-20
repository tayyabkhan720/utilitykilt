<?php
namespace StripeIntegration\Tax\Controller\Adminhtml\Tax\Classes;

/**
 * Interceptor class for @see \StripeIntegration\Tax\Controller\Adminhtml\Tax\Classes
 */
class Interceptor extends \StripeIntegration\Tax\Controller\Adminhtml\Tax\Classes implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Serialize\SerializerInterface $serializer, \Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Framework\App\RequestInterface $request, \Magento\Framework\Message\ManagerInterface $messageManager, \Magento\Framework\Controller\Result\RedirectFactory $resultRedirectFactory, \Magento\Tax\Model\ResourceModel\TaxClass\Collection $taxClassCollection, \Magento\Tax\Api\TaxClassRepositoryInterface $taxClassRepository, \Magento\Tax\Model\ClassModelFactory $taxClassFactory, \StripeIntegration\Tax\Helper\Logger $logger, \Magento\Framework\AuthorizationInterface $authorization)
    {
        $this->___init();
        parent::__construct($serializer, $context, $resultPageFactory, $request, $messageManager, $resultRedirectFactory, $taxClassCollection, $taxClassRepository, $taxClassFactory, $logger, $authorization);
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
