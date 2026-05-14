<?php

namespace App\Providers;

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
        // Set locale from session or default to 'en'
        $locale = session('locale', config('app.locale'));
        if (in_array($locale, ['en', 'fr', 'ar'])) {
            app()->setLocale($locale);
        }
    }
}
