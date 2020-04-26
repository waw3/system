<?php

Route::group(['namespace' => 'Modules\Plugins\Analytics\Http\Controllers', 'middleware' => 'web'], function () {
    Route::group(['prefix' => mconfig('base.config.admin_dir'), 'middleware' => 'auth'], function () {
        Route::group(['prefix' => 'analytics'], function () {
            Route::get('general', [
                'as'   => 'analytics.general',
                'uses' => 'AnalyticsController@getGeneral',
            ]);

            Route::get('page', [
                'as'   => 'analytics.page',
                'uses' => 'AnalyticsController@getTopVisitPages',
            ]);

            Route::get('browser', [
                'as'   => 'analytics.browser',
                'uses' => 'AnalyticsController@getTopBrowser',
            ]);

            Route::get('referrer', [
                'as'   => 'analytics.referrer',
                'uses' => 'AnalyticsController@getTopReferrer',
            ]);
        });
    });
});
