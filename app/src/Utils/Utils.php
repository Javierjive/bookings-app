<?php

namespace App\Utils;

class Utils
{
    /**
     * @param string $date
     * @return \DateTime
     */
    public static function FormatDateTime(string $date): \DateTime
    {
        return new \DateTime('@'.strtotime($date));
    }
}