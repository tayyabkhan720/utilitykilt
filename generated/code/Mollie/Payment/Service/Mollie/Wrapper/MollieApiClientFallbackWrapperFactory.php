<?php
namespace Mollie\Payment\Service\Mollie\Wrapper;

/**
 * Factory class for @see \Mollie\Payment\Service\Mollie\Wrapper\MollieApiClientFallbackWrapper
 */
class MollieApiClientFallbackWrapperFactory
{
    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager = null;

    /**
     * Instance name to create
     *
     * @var string
     */
    protected $_instanceName = null;

    /**
     * Factory constructor
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param string $instanceName
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\Mollie\\Payment\\Service\\Mollie\\Wrapper\\MollieApiClientFallbackWrapper')
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
    }

    /**
     * Create class instance with specified parameters
     *
     * @param array $data
     * @return \Mollie\Payment\Service\Mollie\Wrapper\MollieApiClientFallbackWrapper
     */
    public function create(array $data = [])
    {
        return $this->_objectManager->create($this->_instanceName, $data);
    }
}
