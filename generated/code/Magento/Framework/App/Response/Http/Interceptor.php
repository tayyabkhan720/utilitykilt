<?php
namespace Magento\Framework\App\Response\Http;

/**
 * Interceptor class for @see \Magento\Framework\App\Response\Http
 */
class Interceptor extends \Magento\Framework\App\Response\Http implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Request\Http $request, \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager, \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory $cookieMetadataFactory, \Magento\Framework\App\Http\Context $context, \Magento\Framework\Stdlib\DateTime $dateTime, ?\Magento\Framework\Session\Config\ConfigInterface $sessionConfig = null)
    {
        $this->___init();
        parent::__construct($request, $cookieManager, $cookieMetadataFactory, $context, $dateTime, $sessionConfig);
    }

    /**
     * {@inheritdoc}
     */
    public function setNoCacheHeaders()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setNoCacheHeaders');
        return $pluginInfo ? $this->___callPlugins('setNoCacheHeaders', func_get_args(), $pluginInfo) : parent::setNoCacheHeaders();
    }

    /**
     * {@inheritdoc}
     */
    public function sendResponse()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'sendResponse');
        return $pluginInfo ? $this->___callPlugins('sendResponse', func_get_args(), $pluginInfo) : parent::sendResponse();
    }
}
