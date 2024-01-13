<?php

namespace App\Providers;

use App\Services\Authentication\AuthService;
use App\Services\Authentication\AuthServiceInterface;
use App\Services\Utils\ResponseService;
use App\Services\Utils\ResponseServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ResponseServiceInterface::class, ResponseService::class);
        $this->app->singleton(AuthServiceInterface::class, AuthService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
