<?php
namespace RonAppleton\Socialiser\Http\Controllers;

use RonAppleton\Socialiser\Http\Controller;

class LoginController extends Controller
{
    public function socialLogin($provider)
    {
        return $provider . ' Chosen (Login)';
    }

    public function socialCallback($provider)
    {
        return $provider . ' Chosen (Login)';
    }
}