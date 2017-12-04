<?php

namespace RonAppleton\Socialiser\Http\Controllers;

use RonAppleton\Socialiser\Http\Controller;
use Socialiser;
use Auth;
use GuzzleHttp\Exception\ClientException;
use RonAppleton\Socialiser\Models\SocialUser;

class LoginController extends Controller
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = config('socialiser.userModel.fullyNameSpacedUserModel');
    }

    public function redirectToProvider($provider)
    {
        $this->provider = $provider;

        $this->checkProvider();

        return $this->statefulRedirect();
    }

    public function statelessRedirectToProvider($provider)
    {
        $this->provider = $provider;

        $this->checkProvider();

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

    protected function handleUser(User $sUser)
    {
        $user = SocialUser::where('email', $sUser->getEmail())->first();

        if ($user) {

            $this->updateSocialData($user, $sUser);

        } else {

            $user = $this->storeNewUser($sUser);

        }

        Auth::login($user, true);

        return redirect(config('socialiser.redirect_url'));
    }

    private function providerIsAllowed()
    {
        return in_array($this->provider, config('socialiser.enabled.providers')) && config()->has("socialiser.{$this->provider}");
    }

    private function checkProvider()
    {
        if (!$this->providerIsAllowed()) {

            return redirect('login');

        }

        return true;
    }

    private function updateSocialData(SocialUser $user, User $sUser)
    {
        $user->update([
            'avatar' => $sUser->avatar,
            'provider' => $this->provider,
            'provider_id' => $sUser->id,
            'access_token' => $sUser->token
        ]);
    }

    private function storeNewUser(User $user)
    {
        return User::create([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'avatar' => $user->getAvatar(),
            'provider' => $this->provider,
            'provider_id' => $user->getId(),
            'access_token' => $user->token,
            'password' => str_random(11),
        ]);
    }

    private function statelessRedirect()
    {
        $this->providerHasStateless();

        return $this->handleStatelessScopes();
    }

    private function statelessCallback()
    {
        return $this->providerHasStateless() ?:

            Socialite::driver($this->provider)->stateless()->user();
    }

    private function statefulRedirect()
    {
        return $this->handleStatefulScopes();
    }

    private function statefulCallback()
    {
        return Socialite::driver($this->provider)->user();
    }

    private function handleStatefulScopes()
    {
        return $this->providerHasScopes() ?

            Socialite::driver($this->provider)->scopes(config()->get("socialiser.{$this->provider}.scopes"))->redirect()

            :

            Socialite::driver($this->provider)->redirect();
    }

    private function handleStatelessScopes()
    {
        return $this->providerHasScopes() ?

            Socialite::driver($this->provider)->scopes(config()->get("socialiser.{$this->provider}.scopes"))->stateless()->redirect()

            :

            Socialite::driver($this->provider)->stateless()->redirect();
    }

    private function providerHasScopes()
    {
        if (method_exists(Socialite::driver($this->provider), 'scopes')) {
            return true;
        }

        return false;
    }

    private function providerHasStateless()
    {
        if (method_exists(Socialite::driver($this->provider), 'stateless')) {
            return true;
        }

        return false;
    }
}