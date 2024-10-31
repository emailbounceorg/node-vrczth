<?php

namespace App\Providers;

use App\Models\Settings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class TimeZoneServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Add any necessary registrations here, if required.
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        try {
            // Check if the Settings table exists and has the 'timezones' column.
            if (Schema::hasTable('settings') && Schema::hasColumn('settings', 'timezones')) {
                $settings = Settings::select('timezones')->latest()->first();
                if (!is_null($settings) && !empty($settings->timezones)) {
                    Config::set('app.timezone', $settings->timezones);
                    date_default_timezone_set($settings->timezones); // Optional: set default PHP timezone
                }
            }
        } catch (\Exception $e) {
            // Handle any exceptions that might occur during the process.
            // You can log the error or perform any other appropriate action.
            // For debugging purposes, you can uncomment the following line to see the error:
            // dd($e->getMessage());
        }
    }
}
