<?php

namespace App\Providers;

use App\Http\Controllers\Panel\NotificationController;
use App\Repositories\Panel\NotificationRepository;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{

    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('NotificationController', function($app) {
            return new NotificationController(new NotificationRepository());
        });
    }

    public function provides()
    {
        return ['NotificationController'];
    }

}
