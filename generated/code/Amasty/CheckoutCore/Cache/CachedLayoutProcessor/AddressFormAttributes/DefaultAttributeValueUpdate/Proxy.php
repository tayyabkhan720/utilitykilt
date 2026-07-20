<?php
namespace Amasty\CheckoutCore\Cache\CachedLayoutProcessor\AddressFormAttributes\DefaultAttributeValueUpdate;

/**
 * Proxy class for @see \Amasty\CheckoutCore\Cache\CachedLayoutProcessor\AddressFormAttributes\DefaultAttributeValueUpdate
 */
class Proxy extends \Amasty\CheckoutCore\Cache\CachedLayoutProcessor\AddressFormAttributes\DefaultAttributeValueUpdate implements \Magento\Framework\ObjectManager\NoninterceptableInterface
{
    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager = null;

    /**
     * Proxied instance name
     *
     * @var string
     */
    protected $_instanceName = null;

    /**
     * Proxied instance
     *
     * @var \Amasty\CheckoutCore\Cache\CachedLayoutProcessor\AddressFormAttributes\DefaultAttributeValueUpdate
     */
    protected $_subject = null;

    /**
     * Instance shareability flag
     *
     * @var bool
     */
    protected $_isShared = null;

    /**
     * Proxy constructor
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param string $instanceName
     * @param bool $shared
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\Amasty\\CheckoutCore\\Cache\\CachedLayoutProcessor\\AddressFormAttributes\\DefaultAttributeValueUpdate', $shared = true)
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
        $this->_isShared = $shared;
    }

    /**
     * @return array
     */
    public function __sleep()
    {
        return ['_subject', '_isShared', '_instanceName'];
    }

    /**
     * Retrieve ObjectManager from global scope
     */
    public function __wakeup()
    {
        $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    }

    /**
     * Clone proxied instance
     */
    public function __clone()
    {
        if ($this->_subject) {
            $this->_subject = clone $this->_getSubject();
        }
    }

    /**
     * Debug proxied instance
     */
    public function __debugInfo()
    {
        return ['i' => $this->_subject];
    }

    /**
     * Get proxied instance
     *
     * @return \Amasty\CheckoutCore\Cache\CachedLayoutProcessor\AddressFormAttributes\DefaultAttributeValueUpdate
     */
    protected function _getSubject()
    {
        if (!$this->_subject) {
            $this->_subject = true === $this->_isShared
                ? $this->_objectManager->get($this->_instanceName)
                : $this->_objectManager->create($this->_instanceName);
        }
        return $this->_subject;
    }

    /**
     * {@inheritdoc}
     */
    public function updateDefaultValuesOfLayoutJs(array $layoutJsAttributes): array
    {
        return $this->_getSubject()->updateDefaultValuesOfLayoutJs($layoutJsAttributes);
    }

    /**
     * {@inheritdoc}
     */
    public function merge($elements, $providerName, $dataScopePrefix, array $fields = [])
    {
        return $this->_getSubject()->merge($elements, $providerName, $dataScopePrefix, $fields);
    }
}
