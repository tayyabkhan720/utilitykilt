<?php
declare(strict_types=1);

namespace Utility\ReactCheckout\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class CheckoutLayout implements ArgumentInterface
{
    private const XML_PATH_VARIANT = 'react_checkout/layout/variant';

    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig,
        private readonly StoreManagerInterface $storeManager
    ) {
    }

    public function getVariant(): string
    {
        $store = $this->storeManager->getStore();

        $variant = $this->scopeConfig->getValue(
            self::XML_PATH_VARIANT,
            ScopeInterface::SCOPE_STORE,
            $store
        );

        return $variant === 'two-column' ? 'two-column' : 'three-column';
    }
}