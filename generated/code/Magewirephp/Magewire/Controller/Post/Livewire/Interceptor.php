<?php
namespace Magewirephp\Magewire\Controller\Post\Livewire;

/**
 * Interceptor class for @see \Magewirephp\Magewire\Controller\Post\Livewire
 */
class Interceptor extends \Magewirephp\Magewire\Controller\Post\Livewire implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory, \Magento\Framework\Serialize\SerializerInterface $serializer, \Magewirephp\Magewire\Model\HttpFactory $httpFactory, \Magewirephp\Magewire\Helper\Security $securityHelper, \Magento\Framework\App\RequestInterface $request, \Psr\Log\LoggerInterface $logger, \Magewirephp\Magewire\ViewModel\Magewire $magewireViewModel, \Magewirephp\Magewire\Model\ComponentResolver $componentResolver)
    {
        $this->___init();
        parent::__construct($resultJsonFactory, $serializer, $httpFactory, $securityHelper, $request, $logger, $magewireViewModel, $componentResolver);
    }

    /**
     * {@inheritdoc}
     */
    public function execute(): \Magento\Framework\Controller\Result\Json
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        return $pluginInfo ? $this->___callPlugins('execute', func_get_args(), $pluginInfo) : parent::execute();
    }
}
