<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\Company;
use App\Services\CompanyService;

class CustomServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Company::class,CompanyService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
