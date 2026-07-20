<?php
namespace Magewirephp\Magewire\Controller\Vintage\Livewire;

/**
 * Interceptor class for @see \Magewirephp\Magewire\Controller\Vintage\Livewire
 */
class Interceptor extends \Magewirephp\Magewire\Controller\Vintage\Livewire implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magewirephp\Magewire\Controller\Post\Livewire $origin)
    {
        $this->___init();
        parent::__construct($context, $origin);
    }

    /**
     * {@inheritdoc}
     */
    public function execute(): \Magento\Framework\Controller\Result\Json
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
