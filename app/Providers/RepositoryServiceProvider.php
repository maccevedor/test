<?php

namespace App\Providers;

use App\Domain\Repositories\CompanyRepository;
use App\Domain\Repositories\CompanyUserRepository;
use App\Domain\Repositories\PlanRepository;
use App\Domain\Repositories\SubscriptionRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PlanRepository::class, \App\Infrastructure\Persistence\Eloquent\EloquentPlanRepository::class);
        $this->app->bind(CompanyRepository::class, \App\Infrastructure\Persistence\Eloquent\EloquentCompanyRepository::class);
        $this->app->bind(SubscriptionRepository::class, \App\Infrastructure\Persistence\Eloquent\EloquentSubscriptionRepository::class);
        $this->app->bind(CompanyUserRepository::class, \App\Infrastructure\Persistence\Eloquent\EloquentCompanyUserRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
