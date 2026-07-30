<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Product Feed for Magento 2
*/

namespace Amasty\Feed\Exceptions;

class ReindexInProgressException extends \Magento\Framework\Exception\LocalizedException
{
    public function __construct(\Magento\Framework\Phrase $phrase = null, \Exception $cause = null, $code = 0)
    {
        if (!$phrase) {
            $phrase = __('Couldn\'t lock indexer. Reindex in progress.');
        }
        parent::__construct($phrase, $cause, (int) $code);
    }
}
