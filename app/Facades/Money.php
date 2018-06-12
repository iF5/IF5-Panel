<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Money extends Facade
{

    /**
     * @param string $value
     * @return null|string
     */
    public static function toDecimal($value)
    {
        if (!$value) {
            return null;
        }

        $value = str_replace(',', '.', $value);
        if (!strpos($value, '.')) {
            return sprintf('%d.00', $value);
        }

        $length = strlen($value);
        $prefix = str_replace('.', '', substr($value, 0, ($length - 3)));
        $suffix = substr($value, ($length - 2), 2);
        $separator = substr($value, ($length - 3), 1);
        return sprintf('%s%s%s', $prefix, ($separator === '.') ? '.' : "{$separator}.", $suffix);
    }

}