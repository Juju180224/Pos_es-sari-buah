<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
        Schema::defaultStringLength(191);

        if (! $this->app->runningInConsole()) {

            $settings = Setting::query()
                ->select('key', 'value')
                ->get()
                ->keyBy('key')
                ->map(fn ($setting) => $setting->value)
                ->toArray();

            config(['settings' => $settings]);

            // aman dari error jika key tidak ada
            if (!empty($settings['app_name'])) {
                config(['app.name' => $settings['app_name']]);
            }
        }

        Paginator::useBootstrap();
    }
}