<?php

namespace RonAppleton\Socialiser\Facades;

use Illuminate\Support\Facades\Facade;
use RonAppleton\Socialiser\Contracts\Factory;

/**
 * @see RonAppleton\Socialiser\SocialiserManager
 */
class Socialite extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Factory::class;
    }
}
