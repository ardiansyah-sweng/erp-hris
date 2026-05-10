<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\JobroleService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(JobroleService::class, function ($app) {
            return new JobroleService();
        });
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