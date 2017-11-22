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
     * @return int
     */
    public static function getCurrentId()
    {
        $id = (\Session::has(self::LABEL)) ? \Session::get(self::LABEL)->id : \Auth::user()->providerId;
        return (int)$id;
    }

    /**
     * @param $company
     */
    public static function persist($company)
    {
        \Session::put(self::LABEL, $company);
    }

}