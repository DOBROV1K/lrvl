<?php

namespace App\Providers;

use App\Models\Club;
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
        Gate::define('update-club', function ($user, Club $club) {
            return $user->id === $club->user_id || $user->isAdmin();
        });

        Gate::define('delete-club', function ($user, Club $club) {
            return $user->id === $club->user_id || $user->isAdmin();
        });

        Gate::define('restore-club', function ($user) {
            return $user->isAdmin();
        });

        Gate::define('force-delete-club', function ($user) {
            return $user->isAdmin();
        });
    }
}
