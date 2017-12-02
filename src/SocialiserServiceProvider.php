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

    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'RonAppleton\Socialiser\Http\Controllers';



    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/socialiser.php' => config_path('socialiser.php'),
        ]);
        ;
        $this->loadRoutesFrom(__DIR__.'/Http/routes.php');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }

    public function register()
    {
        $this->app->singleton(Factory::class, function ($app) {
            return new SocialiserManager($app);
        });
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