<?php

namespace App\Http\Traits;

trait AuthTrait
{

    /**
     * @return bool
     */
    protected function isAdmin()
    {
        return (\Auth::user()->role === 'admin');
    }

    /**
     * @return bool
     */
    protected function isCompany()
    {
        return (\Auth::user()->role === 'company');
    }

    /**
     * @return bool
     */
    protected function isProvider()
    {
        return (\Auth::user()->role === 'provider');
    }

    /**
     * @param array $array
     * @return bool
     */
    protected function hasRole(array $array)
    {
        return (in_array(\Auth::user()->role, $array));
    }

}