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
     * @return int
     */
    public static function getCurrentId()
    {
        $id = (\Session::has(self::LABEL)) ? \Session::get(self::LABEL)->id : \Auth::user()->providerId;
        return (int)$id;
    }

    /**
     * @param $provider
     */
    public static function persist($provider)
    {
        \Session::put(self::LABEL, $provider);
    }

}