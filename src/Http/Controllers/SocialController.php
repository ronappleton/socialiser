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

    public function statelessRedirectToProvider()
    {
        if ($this->providerHasStateless()) {
            return $this->statelessRedirect();
        }

        return redirect('login');
    }

    public function handleProviderCallback()
    {
        try {

            $user = $this->statefulCallback();

        } catch (ClientException $e) {

            return redirect('login');

        }

        return $this->handleUser($user);
    }

    public function handleStatelessProviderCallback()
    {
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
            if($user = $this->userModel::where('email', $sUser->getEmail())->first())
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

        $redirectTo = Auth::check() ? config('socialiser.redirect_url') : redirect('login');
        //redirect must be decided above as a delay in the return from config can cause issues on redirect,
        //causing the object to be returned instead of the string.
        return redirect($redirectTo);
    }








}