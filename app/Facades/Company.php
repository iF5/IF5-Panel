<?php

namespace App\Facades;

use \Illuminate\Support\Facades\Facade;

class Company extends Facade
{

    /**
     * @const int
     */
    const ID = 1;

    /**
     * @const string
     */
    const LABEL = 'company';

    /**
     * @return object | null
     */
    public static function getCurrent()
    {
        return (\Session::has(self::LABEL)) ? \Session::get(self::LABEL) : null;
    }

    /**
     * @return int
     */
    public static function getCurrentId()
    {
        return (self::getCurrent()) ? (int)self::getCurrent()->id : (int)\Auth::user()->companyId;
    }

    /**
     * @param string $argument
     * @return null | string
     */
    public static function getCurrentAs($argument)
    {
        $current = self::getCurrent();
        return ($current && isset($current->$argument)) ? $current->$argument : null;
    }

    /**
     * @param $company
     */
    public static function persist($company)
    {
        \Session::put(self::LABEL, $company);
    }

}