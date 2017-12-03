<?php
return [
    /**
     * Setting this array will allow socialiser whilst running its migration to link social user data to your system users,
     * if fullyNameSpacedUserModel is not set, no foreign key will be created.
     * if fullyNameSpacedUserModel is set, socialiser will always attempt to discover the table name and primary key column
     * before falling back on the values userTableName and userPrimaryKeyColumn
     */
    'userModel' => [
        'fullyNameSpacedUserModel' => '', //Optional if you don't want a foreign key linking to user, just ignore, example App\User
        'userTableName' => 'users', //Optional if $protected $table is set in model, example users
        'userPrimaryKeyColumn' => 'id', //Optional if $protected $primaryKey is set in model, example id
        ],

    'middleware' => [
      'login'   => [ 'web', 'guest' ],
      'connect' => [ 'web', 'auth' ],
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