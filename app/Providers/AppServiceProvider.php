<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;
use App\Models\EmailSetting;

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
        if (env('USE_DYNAMIC_SMTP', false)) {
            $emailSettings = EmailSetting::find(1);
            
            if ($emailSettings) {
                Config::set('mail.mailers.smtp.host', $emailSettings->smtp_host);
                Config::set('mail.mailers.smtp.port', $emailSettings->smtp_port);
                Config::set('mail.mailers.smtp.encryption', $emailSettings->encryption_type);
                Config::set('mail.mailers.smtp.username', $emailSettings->smtp_username);
                Config::set('mail.mailers.smtp.password', $emailSettings->smtp_password);
                Config::set('mail.from.address', $emailSettings->from_email);
                Config::set('mail.from.name', $emailSettings->from_name);
            }
        }
    }
}
