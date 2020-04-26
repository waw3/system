<?php

use Modules\Base\Http\Controllers\SystemController;

Route::group(['prefix' => mconfig('base.config.admin_dir'), 'middleware' => 'auth'], function () {
    Route::group(['prefix' => 'system/info'], function () {
        Route::get('', [
            'as'         => 'system.info',
            'uses'       => 'SystemController@getInfo',
            'permission' => 'superuser',
        ]);
    });

    Route::group(['prefix' => 'system/cache'], function () {

        Route::get('', [
            'as'         => 'system.cache',
            'uses'       => 'SystemController@getCacheManagement',
            'permission' => 'superuser',
        ]);

        Route::post('clear', [
            'as'         => 'system.cache.clear',
            'uses'       => 'SystemController@postClearCache',
            'permission' => 'superuser',
            'middleware' => 'preventDemo',
        ]);
    });

    Route::post('membership/authorize', [
        'as'         => 'membership.authorize',
        'uses'       => 'SystemController@authorize',
        'permission' => 'superuser',
    ]);
});

Route::get('settings-language/{alias}', [SystemController::class, 'getLanguage'])->name('settings.language');
