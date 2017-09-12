<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Service\CheckoutService;

class CheckoutServiceProvider extends ServiceProvider
{
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
        $this->app->bind('App\Service\CheckoutService', CheckoutService::class);
    }
}
