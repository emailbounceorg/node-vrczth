<?php

namespace App\Providers;

use App\Models\SMTPDetails;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

class MailConfigProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $configuration = SMTPDetails::first();

            if (!is_null($configuration)) {
                if ($configuration->driver == 'ses') {
                    Config::set('mail.default', $configuration->driver);
                    Config::set('services.ses.key', $configuration->awsAccessKey);
                    Config::set('services.default', $configuration->driver);
                    Config::set('services.ses.secret', $configuration->awsSecretKey);
                    Config::set('services.ses.region', $configuration->awsDefaultRegion ?? 'us-east-1');
                    Config::set('mail.from.address', $configuration->smtp_from_email);
                    Config::set('mail.from.name', $configuration->smtp_from_name);
                } else {
                    Config::set('mail.default', $configuration->driver);
                    Config::set('mail.mailers.smtp.host', $configuration->smtp_host);
                    Config::set('mail.mailers.smtp.port', $configuration->smtp_port);
                    Config::set('mail.mailers.smtp.username', $configuration->username);
                    Config::set('mail.mailers.smtp.password', $configuration->smtp_pass);
                    Config::set('mail.mailers.smtp.encryption', $configuration->encryption);
                    Config::set('mail.from.address', $configuration->smtp_from_email);
                    Config::set('mail.from.name', $configuration->smtp_from_name);
                }
            }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
