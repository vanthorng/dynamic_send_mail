<?php

namespace App\Providers;

use App\Models\EmailConfiguration;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
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
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Dynamically set mail configuration based on logged-in user
        view()->composer('email', function ($view) {
            if (isset(Auth::user()->id)) {
                $configuration = EmailConfiguration::where("user_id", Auth::user()->id)->first();

                if (!is_null($configuration)) {
                    $config = [
                        'driver'     => $configuration->driver,
                        'host'       => $configuration->host,
                        'port'       => $configuration->port,
                        'username'   => $configuration->user_name,
                        'password'   => $configuration->password,
                        'encryption' => $configuration->encryption,
                        'from'       => [
                            'address' => $configuration->sender_email,
                            'name'    => $configuration->sender_name,
                        ],
                    ];

                    Config::set('mail', $config);
                }
            }
        });
    }
}
