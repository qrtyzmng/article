<?php

namespace App\Util;

class Twig {
    /**
     * 
     * @param string $data
     * @param int $characterLimit
     * @return string
     */
    public static function getShortContent($data, $characterLimit)
    {
        $formattedData = strip_tags($data);
        if (strlen($formattedData) > $characterLimit) {
            $formattedData = substr($formattedData, 0, 99). "...";
        }
        
        return $formattedData;
    }        
}
