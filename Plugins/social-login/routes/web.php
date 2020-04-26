<?php

Route::group(['namespace' => 'Modules\Plugins\SocialLogin\Http\Controllers', 'middleware' => 'web'], function () {

    Route::group(['prefix' => mconfig('base.config.admin_dir'), 'middleware' => 'auth'], function () {
        Route::group(['prefix' => 'social-login'], function () {

            Route::get('settings', [
                'as'   => 'social-login.settings',
                'uses' => 'SocialLoginController@getSettings',
            ]);

            Route::post('settings', [
                'as'   => 'social-login.settings',
                'uses' => 'SocialLoginController@postSettings',
            ]);
        });
    });

    Route::get('auth/{provider}', [
        'as'   => 'auth.social',
        'uses' => 'SocialLoginController@redirectToProvider',
    ]);

    Route::get('auth/callback/{provider}', [
        'as'   => 'auth.social.callback',
        'uses' => 'SocialLoginController@handleProviderCallback',
    ]);

});
