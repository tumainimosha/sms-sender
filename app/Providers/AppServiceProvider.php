<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        # ensure you configure the right channel you use
        config(['logging.channels.daily.path' => \Phar::running()
            ? dirname(\Phar::running(false)) . '/logs/sms-sender.log'
            : storage_path('logs/sms-sender.log'),
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $db_driver = $this->app['config']['database']['default'];

        // Register oracle driver if using oracle db
        if ($db_driver === 'oracle') {
            $this->app->register(\Yajra\Oci8\Oci8ServiceProvider::class);
        }
    }
}
