<?php
/**
 * Created by PhpStorm.
 * User: ron
 * Date: 12/4/17
 * Time: 8:05 PM
 */

namespace RonAppleton\Socialiser\Http\Controllers;

use Auth;
use RonAppleton\Socialiser\Http\Controller;
use Socialiser;
use RonAppleton\Socialiser\Models\SocialUser;

abstract class AbstractSocialController extends Controller
{
    protected $provider;
    protected $userModel;

    public function __construct($provider)
    {
        $this->provider = $provider;
        $this->userModel = config('socialiser.userModel.fullyNameSpacedUserModel');
        if (!$this->providerIsAllowed()) {
            if (Auth::check()) {
                return redirect('home');
            }
            return redirect('login');
        }

    }

    private function providerIsAllowed()
    {
        return in_array($this->provider, config('socialiser.enabled.providers')) && config()->has("socialiser.{$this->provider}");
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

    public function storeSocialUser($sUser, $id)
    {
        SocialUser::updateOrCreate([
            'user_id' => $id,
            'provider' => $this->provider,
            'provider_id' => $sUser->getId(),
            'name' => $sUser->getName(),
            'nickname' => $sUser->getNickName(),
            'email' => $sUser->getEmail(),
            'avatar' => $sUser->getAvatar(),
            'token' => $sUser->token,
            'refresh_token' => null,
            'expires_in' => null,
        ]);
    }

    protected function storeNewUser($user)
    {
        return $this->userModel::create([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => str_random(11),
        ]);
    }
}