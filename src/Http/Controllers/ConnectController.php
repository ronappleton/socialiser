<?php
namespace RonAppleton\Socialiser\Http\Controllers;

use RonAppleton\Socialiser\Http\Controller;

class ConnectController extends Controller
{
    public function socialLogin($provider)
    {
        return $provider . ' Chosen (Connect)';
    }

    public function socialCallback($provider)
    {
        return $provider . ' Chosen (Connect)';
    }
}