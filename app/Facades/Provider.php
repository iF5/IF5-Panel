<?php

namespace App\Facades;

use \Illuminate\Support\Facades\Facade;

class Provider extends Facade
{

    /**
     * @const int
     */
    const ID = 2;

    /**
     * @const string
     */
    const LABEL = 'provider';

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
        return (self::getCurrent()) ? (int)self::getCurrent()->id : (int)\Auth::user()->providerId;
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
     * @param $provider
     */
    public static function persist($provider)
    {
        \Session::put(self::LABEL, $provider);
    }

}