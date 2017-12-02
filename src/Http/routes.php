<?php
Route::group(['prefix' => 'socialiser'], function () {
    Route::group(['prefix' => 'login'], function () {
        Route::get('{provider}', 'RonAppleton\Socialiser\Http\Controllers@socialLogin');
        Route::get('{provider}/callback', 'RonAppleton\Socialiser\Http\Controllers@csocialCallback');
    });

    Route::group(['prefix' => 'connect'], function () {
        Route::get('{provider}', 'RonAppleton\Socialiser\Http\Controllers@socialLogin');
        Route::get('{provider}/callback', 'RonAppleton\Socialiser\Http\Controllers@socialCallback');
    });
});

