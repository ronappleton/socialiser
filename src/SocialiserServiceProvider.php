<?php
namespace RonAppleton\Socialiser;

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Contracts\Factory;
use Laravel\Socialite\SocialiteServiceProvider;

class SocialiserServiceProvider extends SocialiteServiceProvider
{

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
}