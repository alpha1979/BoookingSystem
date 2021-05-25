<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Libraries;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        // $this->app->bind('App\Libraries\NotificationsInteface',function($app){
        //     return new \App\Libraries\Notifications();
        // });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}