<?php

namespace App\Providers;

use App\Models\Fund;
use App\Models\User;
use App\Policies\FundPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Gate::define('delete-fund', [FundPolicy::class, 'delete']);
    }
}
