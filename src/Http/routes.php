<?php
Route::group(['prefix' => 'socialiser'], function () {
        Route::get('{provider}', 'RonAppleton\Socialiser\Http\Controllers\SocialController@redirectToProvider');
        Route::get('{provider}/callback', 'RonAppleton\Socialiser\Http\Controllers\SocialController@handleProviderCallback');

    Route::group(['prefix' => 'stateless', 'middleware' => config('socialiser.middleware.connect')], function () {
        Route::get('{provider}', 'RonAppleton\Socialiser\Http\Controllers\SocialController@statelessRedirectToProvider');
        Route::get('{provider}/callback', 'RonAppleton\Socialiser\Http\Controllers\SocialController@handleStatelessProviderCallback');
    });

});