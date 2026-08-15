<?php
declare(strict_types=1);

namespace Utility\ReactCheckout\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class LayoutVariant implements ArrayInterface
{
    public function toOptionArray(): array
    {
        return [
            ['value' => 'two-column', 'label' => __('Two Column')],
            ['value' => 'three-column', 'label' => __('Three Column')],
        ];
    }
}