<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (IF5_ENV === 'production') {
            $this->app['request']->server->set('HTTPS', true);
        }

        \Validator::extend('unique_multiple', '\App\Http\Validations\UniqueMultiple@has');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
