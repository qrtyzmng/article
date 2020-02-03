<?php

namespace App\Util;

class Rate {

    /**
     * 
     * @param int $value
     * @param int $amount
     * @return int
     */
    public static function calculateRate($value, $amount)
    {
        if ($amount > 0) {
            return $value/$amount;
        }
        
        return $value;
    }        
}
