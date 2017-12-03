<?php
Route::group(['prefix' => 'socialiser'], function () {
    Route::group(['prefix' => 'login', 'middleware' => ['web', 'guest']], function () {
        Route::get('{provider}', 'RonAppleton\Socialiser\Http\Controllers\LoginController@socialLogin');
        Route::get('{provider}/callback', 'RonAppleton\Socialiser\Http\Controllers\LoginController@socialCallback');
    });

    Route::group(['prefix' => 'connect', 'middleware' => ['web', 'auth']], function () {
        Route::get('{provider}', 'RonAppleton\Socialiser\Http\Controllers\ConnectController@socialLogin');
        Route::get('{provider}/callback', 'RonAppleton\Socialiser\Http\Controllers\ConnectController@socialCallback');
    });
});