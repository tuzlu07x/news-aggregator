<?php

namespace App\Providers;

use App\Repositories\User\AuthRepository;
use App\Repositories\User\AuthRepositoryImpl;
use App\Services\User\AuthService;
use App\Services\User\AuthServiceImpl;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthServiceImpl::class, AuthService::class);
        $this->app->bind(AuthRepositoryImpl::class, AuthRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
