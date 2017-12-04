<?php

namespace RonAppleton\Socialiser\Http\Controllers;

use Illuminate\Http\Request;
use Socialiser;
use Auth;
use GuzzleHttp\Exception\ClientException;
use RonAppleton\Socialiser\Models\SocialUser;

class SocialController extends AbstractSocialController
{
    public function __construct(Request $request)
    {
        parent::__construct($request->provider);
    }

    public function redirectToProvider()
    {
        return $this->statefulRedirect();
    }

    public function statelessRedirectToProvider($provider)
    {
        if ($this->providerHasStateless()) {
            return $this->statelessRedirect();
        }

        return redirect('login');
    }

    public function handleProviderCallback($provider)
    {
        $this->provider = $provider;

        $this->checkProvider();

        try {

            $user = $this->statefulCallback();

        } catch (ClientException $e) {

            return redirect('login');

        }

        return $this->handleUser($user);
    }

    public function handleStatelessProviderCallback($provider)
    {
        $this->provider = $provider;

        $this->checkProvider();

        try {

            $user = $this->statelessCallback();

        } catch (ClientException $e) {

            return redirect('login');

        }

        return $this->handleUser($user);
    }

    protected function handleUser($sUser)
    {
        if(Auth::check())
        {
            /**
             * We are logged in already, so we are just connecting this account.
             */
            $userId = Auth::id();
        }
        else {
            /**
             * We are not logged in so this is a login request, so store a new user in the database if needed.
             */
            if($user = SocialUser::where('email', $sUser->getEmail())->first())
            {
                $userId = $user->id;
            }
            else {
                $user = $this->storeNewUser($sUser);
                $userId = $user->id;

            }
            Auth::login($user, true);
        }

        $this->storeSocialUser($sUser, $userId);

        return Auth::check() ? redirect(config('socialiser.redirect_url')) : redirect('login');
    }








}