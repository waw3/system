<?php

Theme::routes();

Route::group(['namespace' => 'Theme\LaraMag\Http\Controllers', 'middleware' => 'web'], function () {
    Route::group(apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []), function () {
        Route::get('/', 'LaraMagController@getIndex')->name('public.index');

        Route::get('sitemap.xml', [
            'as'   => 'public.sitemap',
            'uses' => 'LaraMagController@getSiteMap',
        ]);

        Route::get('{slug?}' . mconfig('base.config.public_single_ending_url'), [
            'as'   => 'public.single',
            'uses' => 'LaraMagController@getView',
        ]);
    });
});
