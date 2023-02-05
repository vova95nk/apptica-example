<?php

namespace App\Providers;

use App\Clients\AppticaClient;
use App\Clients\AppticaClientInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AppticaClientInterface::class, function () {
            return new AppticaClient(
                config('apptica.app.test.id'),
                config('apptica.countries.us')
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
