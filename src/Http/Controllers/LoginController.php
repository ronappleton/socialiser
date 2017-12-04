<?php
namespace RonAppleton\Socialiser\Http\Controllers;

use RonAppleton\Socialiser\Http\Controller;
use RonAppleton\Socialiser\Facades\Socialiser;

class LoginController extends Controller
{
    public function socialLogin($provider)
    {
        return Socialiser::driver($provider)->redirect();
    }

    public function socialCallback($provider)
    {
        try {
            $user = Socialiser::driver($provider)->user();
        } catch (\Exception $e)
        {
            
            dd($e->getMessage());
        }

    }
}