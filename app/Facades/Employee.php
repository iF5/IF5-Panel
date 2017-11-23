<?php

namespace App\Facades;

use \Illuminate\Support\Facades\Facade;

class Employee extends Facade
{

    /**
     * @const int
     */
    const ID = 3;

    /**
     * @const string
     */
    const LABEL = 'employee';

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
        return (self::getCurrent()) ? (int)self::getCurrent()->id : 0;
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
     * @param $employee
     */
    public static function persist($employee)
    {
        \Session::put(self::LABEL, $employee);
    }

}