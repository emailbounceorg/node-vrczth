<?php

namespace App\Providers;

use App\Models\Settings;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

class SocialSettinsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $social_settings = Settings::latest()->first();
            if (!is_null($social_settings)) {
                if ($social_settings->google_on_off == 'on') {
                    Config::set('services.google.client_id', $social_settings->google_client_id);
                    Config::set('services.google.client_secret', $social_settings->google_secret);
                    Config::set('services.google.redirect', route('google.callback'));
                }
            }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
