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

    /**
     * @return int
     */
    protected function getId()
    {
        return \Auth::user()->id;
    }

    /**
     * @return string
     */
    protected function getName()
    {
        return \Auth::user()->name;
    }

    /**
     * @return string
     */
    protected function getEmail()
    {
        return \Auth::user()->email;
    }

    /**
     * @return string
     */
    protected function getRole()
    {
        return \Auth::user()->role;
    }

    /**
     * @return int
     */
    protected function getCompanyId()
    {
        return \Auth::user()->companyId;
    }

    /**
     * @return int
     */
    protected function getProviderId()
    {
        return \Auth::user()->providerId;
    }

}