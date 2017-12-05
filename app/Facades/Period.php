<?php

namespace App\Facades;

use \Illuminate\Support\Facades\Facade;

class Period extends Facade
{

    /**
     * @param null|string $value
     * @param string $format
     * @return null|string
     */
    public static function format($value = null, $format = 'Y-m-d H:i:s')
    {
        if (!$value) {
            return null;
        }

        $value = str_replace(['/'], ['-'], $value);
        return date($format, strtotime($value));
    }

    /**
     * @return array
     */
    public static function getMonths()
    {
        return [
            '01' => 'Janeiro',
            '02' => 'Fevereiro',
            '03' => 'Mar&ccedil;o',
            '04' => 'Abril',
            '05' => 'Maio',
            '06' => 'Junho',
            '07' => 'Julho',
            '08' => 'Agosto',
            '09' => 'Setembro',
            '10' => 'Outubro',
            '11' => 'Novembro',
            '12' => 'Dezembro'
        ];
    }

    /**
     * @param int $back
     * @return array
     */
    public static function getYears($back = 10)
    {
        $current = (int)(new \DateTime())->format('Y');
        $to = $current - $back;
        $years = [];
        for ($i = $current; $i > $to; $i--) {
            $years[] = $i;
        }
        return $years;
    }

}