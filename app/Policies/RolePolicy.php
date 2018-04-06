<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * @var array
     */
    private $roles = [];

    /**
     * @var string
     */
    private $role;

    public function __construct()
    {
        $this->roles = \Config::get('roles.canAccess');
        $this->role = \Auth::user()->role;
    }

    /**
     * Politics for what is admin
     *
     * @return bool
     */
    public function isAdmin()
    {
        return in_array($this->role, $this->roles['admin']);
    }

    /**
     * Politics for what only admin
     *
     * @return bool
     */
    public function onlyAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Politics for what is company
     *
     * @return bool
     */
    public function isCompany()
    {
        return in_array($this->role, $this->roles['company']);
    }

    /**
     * Politics for what only company
     *
     * @return bool
     */
    public function onlyCompany()
    {
        return $this->role === 'company';
    }

    /**
     * Politics for what is provider
     *
     * @return bool
     */
    public function isProvider()
    {
        return in_array($this->role, $this->roles['provider']);
    }

    /**
     * Politics for what only provider
     *
     * @return bool
     */
    public function onlyProvider()
    {
        return $this->role === 'provider';
    }

    /**
     * Politics for what admin or provider
     *
     * @return bool
     */
    public function isAdminOrProvider()
    {
        return in_array($this->role, ['admin', 'provider']);
    }
}
