<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //'App\Model' => 'App\Policies\ModelPolicy',
    ];

    private function registerCustomPolicies()
    {
        \Gate::define('isAdmin', 'App\Policies\RolePolicy@isAdmin');
        \Gate::define('onlyAdmin', 'App\Policies\RolePolicy@onlyAdmin');
        \Gate::define('isCompany', 'App\Policies\RolePolicy@isCompany');
        \Gate::define('onlyCompany', 'App\Policies\RolePolicy@onlyCompany');
        \Gate::define('isProvider', 'App\Policies\RolePolicy@isProvider');
        \Gate::define('onlyProvider', 'App\Policies\RolePolicy@onlyProvider');
    }

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerCustomPolicies();
    }
}
