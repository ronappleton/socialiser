<?php
return [
    'userModel' => [
        'fullyNameSpacedUserModel' => 'App\User',
        'userTableName' => 'users',
        'userPrimaryKeyColumn' => 'id',
        ],

    'middleware' => [
      'login'   => [ 'web', 'guest' ],
      'stateless' => [ 'web', 'guest' ],
    ],

    'login_redirect' => 'home',

    'save_social_users' => true,

    'enabled_providers' => [
        'facebook',
        'instagram',
        'twitter',
        'youtube',
        'github',
        'bitbucket',
        'linkedin',
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect_url' => env('APP_URL') . '/' . env('FACEBOOK_REDIRECT'),
        'scopes' => []
    ],

    'instagram' => [
        'client_id' => env('INSTAGRAM_CLIENT_ID'),
        'client_secret' => env('INSTAGRAM_CLIENT_SECRET'),
        'redirect_url' => env('APP_URL') . '/' . env('INSTAGRAM_REDIRECT'),
        'scopes' => []
    ],

    'twitter' => [
        'client_id' => env('TWITTER_CLIENT_ID'),
        'client_secret' => env('TWITTER_CLIENT_SECRET'),
        'redirect_url' => env('APP_URL') . '/' . env('TWITTER_REDIRECT'),
        'scopes' => []
    ],

    'youtube' => [
        'client_id' => env('YOUTUBE_CLIENT_ID'),
        'client_secret' => env('YOUTUBE_CLIENT_SECRET'),
        'redirect_url' => env('APP_URL') . '/' . env('YOUTUBE_REDIRECT'),
        'scopes' => []
    ],

    'github' => [
        'client_id' => env('GITHUB_CLIENT_ID'),
        'client_secret' => env('GITHUB_CLIENT_SECRET'),
        'redirect_url' => env('APP_URL') . '/' . env('GITHUB_REDIRECT'),
        'scopes' => []
    ],

    'bitbucket' => [
        'client_id' => env('BITBUCKET_CLIENT_ID'),
        'client_secret' => env('BITBUCKET_CLIENT_SECRET'),
        'redirect_url' => env('APP_URL') . '/' . env('BITBUCKET_REDIRECT'),
        'scopes' => []
    ],

    'linkedin' => [
        'client_id' => env('LINKEDIN_CLIENT_ID'),
        'client_secret' => env('LINKEDIN_CLIENT_SECRET'),
        'redirect_url' => env('APP_URL') . '/' . env('LINKEDIN_REDIRECT'),
        'scopes' => []
    ],

];