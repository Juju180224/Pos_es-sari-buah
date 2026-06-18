<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;

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
        // Force HTTPS di production
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }

        Schema::defaultStringLength(191);

        if (! $this->app->runningInConsole()) {
            try {
                if (Schema::hasTable('settings')) {

                    $settings = Setting::query()
                        ->select('key', 'value')
                        ->get()
                        ->pluck('value', 'key')
                        ->toArray();

                    config(['settings' => $settings]);

                    if (!empty($settings['app_name'])) {
                        config(['app.name' => $settings['app_name']]);
                    }
                }
            } catch (\Exception $e) {
                // Database not available during bootstrap
                // Continue with default config
            }
        }

        Paginator::useBootstrap();
    }
}
