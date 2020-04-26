<?php

Theme::routes();

Route::group(['namespace' => 'Theme\Ripple\Http\Controllers', 'middleware' => 'web'], function () {
    Route::group(apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []), function () {

        Route::get('/', 'RippleController@getIndex')->name('public.index');

        Route::get('sitemap.xml', [
            'as'   => 'public.sitemap',
            'uses' => 'RippleController@getSiteMap',
        ]);

        Route::get('{slug?}' . mconfig('base.config.public_single_ending_url'), [
            'as'   => 'public.single',
            'uses' => 'RippleController@getView',
        ]);

    });

});
