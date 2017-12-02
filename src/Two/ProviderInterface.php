<?php

namespace RonAppleton\Socialiser\Two;

interface ProviderInterface
{
    /**
     * Redirect the user to the authentication page for the provider.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirect();

    /**
     * Get the User instance for the authenticated user.
     *
     * @return \RonAppleton\Socialiser\Two\User
     */
    public function user();
}
