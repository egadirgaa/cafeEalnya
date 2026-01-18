<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
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
        $expiredAt = Carbon::create(2026, 2, 20, 0, 0, 0);

        if (!App::runningInConsole() && now()->greaterThanOrEqualTo($expiredAt)) {
            abort(403, 'Aplikasi sudah kedaluwarsa, ');
        }
    }
}
