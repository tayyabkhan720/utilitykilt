<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2020 Amasty (https://www.amasty.com)
 * @package Amasty_SeoRichData
 */


namespace Amasty\SeoRichData\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Breadcrumbs implements OptionSourceInterface
{
    const TYPE_LONG = 0;
    const TYPE_SHORT = 1;

    public function toOptionArray(): array
    {
        return [
            self::TYPE_LONG => __('Default (Long)'),
            self::TYPE_SHORT => __('Short'),
        ];
    }
}
