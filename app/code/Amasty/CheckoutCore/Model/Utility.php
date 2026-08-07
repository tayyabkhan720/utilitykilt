<?php
/**
* @author Amasty Team
* @copyright Copyright (c) 2022 Amasty (https://www.amasty.com)
* @package Amasty_CheckoutCore
*/


namespace Amasty\CheckoutCore\Model;

class Utility
{
    /**
     * The method inserts a new array before some key
     *
     * @param array $origin
     * @param array|string $wantedKey
     * @param array $insert
     *
     * @return array
     */
    public function arrayInsertBeforeKey(
       array        $origin = [],
       array|string $wantedKey = '',
        array       $insert = []
    ) {
        $availableKeys = array_keys($origin);
        $position = array_search($wantedKey, $availableKeys);
        if ($position === false) {
            $position = count($origin);
        }

        $derivative = array_merge(
            array_slice($origin, 0, $position),
            $insert,
            array_slice($origin, $position)
        );

        return $derivative;
    }
}
