<?php
Route::group(['prefix' => 'socialiser'], function () {
    Route::middleware(config('socialiser.middleware.stateful'))->group(function  () {
        Route::get('{provider}', 'RonAppleton\Socialiser\Http\Controllers\SocialController@redirectToProvider');
        Route::get('{provider}/callback', 'RonAppleton\Socialiser\Http\Controllers\SocialController@handleProviderCallback');
    });


    Route::group(['prefix' => 'stateless', 'middleware' => config('socialiser.middleware.stateless')], function () {
        Route::get('{provider}', 'RonAppleton\Socialiser\Http\Controllers\SocialController@statelessRedirectToProvider');
        Route::get('{provider}/callback', 'RonAppleton\Socialiser\Http\Controllers\SocialController@handleStatelessProviderCallback');
    });

});