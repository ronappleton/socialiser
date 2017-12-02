<?php

namespace RonAppleton\Socialiser;

use Illuminate\Support\Facades\Route;
use RonAppleton\Socialiser\Contracts\Factory;
use Illuminate\Support\ServiceProvider;

class SocialiserServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/socialiser.php' => config_path('socialiser.php'),
        ]);

        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }

    public function register()
    {
        $this->app->singleton(Factory::class, function ($app) {
            return new SocialiserManager($app);
        });

        $this->mapSocialiserRoutes();
    }


    /**
     * Define socialisers routes for the application.
     *
     * @return void
     */
    protected function mapSocialiserRoutes()
    {
        Route::prefix('socialiser')
            ->namespace($this->namespace)
            ->group('Http/routes.php');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Factory::class];
    }
}