<?php
Route::group(['prefix' => 'socialiser'], function () {
    Route::group(['prefix' => 'login', 'middleware' => config('socialiser.middleware.login')], function () {
        Route::get('{provider}', 'RonAppleton\Socialiser\Http\Controllers\LoginController@socialLogin');
        Route::get('{provider}/callback', 'RonAppleton\Socialiser\Http\Controllers\LoginController@socialCallback');
    });

    Route::group(['prefix' => 'connect', 'middleware' => config('socialiser.middleware.connect')], function () {
        Route::get('{provider}', 'RonAppleton\Socialiser\Http\Controllers\ConnectController@socialLogin');
        Route::get('{provider}/callback', 'RonAppleton\Socialiser\Http\Controllers\ConnectController@socialCallback');
    });
    
});