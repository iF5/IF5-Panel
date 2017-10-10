<?php

namespace App\Facades;

use \Illuminate\Support\Facades\Facade;

class DateFormat extends Facade
{

    /**
     * @param null|string $datetime
     * @param string $format
     * @return null|string
     */
    public static function to($datetime = null, $format = 'Y-m-d H:i:s')
    {
        if (!$datetime) {
            return null;
        }

        return (new \DateTime($datetime))->format($format);
    }

}