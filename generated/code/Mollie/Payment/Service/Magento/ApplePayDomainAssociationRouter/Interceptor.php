<?php
namespace Mollie\Payment\Service\Magento\ApplePayDomainAssociationRouter;

/**
 * Interceptor class for @see \Mollie\Payment\Service\Magento\ApplePayDomainAssociationRouter
 */
class Interceptor extends \Mollie\Payment\Service\Magento\ApplePayDomainAssociationRouter implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\ActionFactory $actionFactory, \Magento\Framework\App\Router\ActionList $actionList, \Magento\Framework\App\Route\ConfigInterface $routeConfig)
    {
        $this->___init();
        parent::__construct($actionFactory, $actionList, $routeConfig);
    }

    /**
     * {@inheritdoc}
     */
    public function match(\Magento\Framework\App\RequestInterface $request): ?\Magento\Framework\App\ActionInterface
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'match');
        return $pluginInfo ? $this->___callPlugins('match', func_get_args(), $pluginInfo) : parent::match($request);
    }
}
