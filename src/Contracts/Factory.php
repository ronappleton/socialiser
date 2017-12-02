<?php

namespace RonAppleton\Socialiser\Contracts;

interface Factory
{
    /**
     * Get an OAuth provider implementation.
     *
     * @param  string  $driver
     * @return \RonAppleton\Socialiser\Contracts\Provider
     */
    public function driver($driver = null);
}
