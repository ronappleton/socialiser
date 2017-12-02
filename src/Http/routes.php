<?php
Route::group(['prefix' => 'socialiser'], function () {
    Route::group(['prefix' => 'login'], function () {
        Route::get('{provider}', 'RonAppleton\Socialiser\Http\Controllers\LoginController@socialLogin');
        Route::get('{provider}/callback', 'RonAppleton\Socialiser\Http\Controllers\LoginController@csocialCallback');
    });

    Route::group(['prefix' => 'connect'], function () {
        Route::get('{provider}', 'RonAppleton\Socialiser\Http\Controllers\ConnectController@socialLogin');
        Route::get('{provider}/callback', 'RonAppleton\Socialiser\Http\Controllers\ConnectController@socialCallback');
    });
});

