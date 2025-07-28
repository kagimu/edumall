<?php

namespace App\Providers;
use Laravel\Passport\Passport;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
         Passport::ignoreRoutes();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        if (config('app.env') === 'production') {
            URL::forceScheme('https');

            // Trust the Railway.app load balancer
            $this->app['request']->server->set('HTTPS', 'on');

            // If you're behind a load balancer
            if ($this->app->environment('production')) {
                \Illuminate\Support\Facades\URL::forceScheme('https');
                $this->app['request']->server->set('HTTPS', 'on');
            }
        }

        // Automatically run "storage:link" if the link doesn't exist
        if (!File::exists(public_path('storage'))) {
            Artisan::call('storage:link');
        }
    }
}
