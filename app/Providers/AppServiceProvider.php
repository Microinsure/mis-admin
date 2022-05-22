<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Customer;
use App\Observers\CustomerObserver;

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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Observe changes to Customer Model
        Customer::observe(CustomerObserver::class);
    }
}
