<?php

namespace App\Providers;

use App\Repositories\Preference\PreferenceRepository;
use App\Repositories\Preference\PreferenceRepositoryImpl;
use App\Repositories\User\AuthRepository;
use App\Repositories\User\AuthRepositoryImpl;
use App\Services\Preference\PreferenceService;
use App\Services\Preference\PreferenceServiceImpl;
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
        $this->serviceBinds();
        $this->repositoryBinds();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    private function serviceBinds(): void
    {
        $this->app->bind(AuthServiceImpl::class, AuthService::class);
        $this->app->bind(PreferenceServiceImpl::class, PreferenceService::class);
    }

    private function repositoryBinds(): void
    {
        $this->app->bind(AuthRepositoryImpl::class, AuthRepository::class);
        $this->app->bind(PreferenceRepositoryImpl::class, PreferenceRepository::class);
    }
}
