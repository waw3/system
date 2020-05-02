<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => mconfig('base.config.admin_dir'), 'middleware' => 'auth'], function () {

    Route::group(['prefix' => 'galleries', 'as' => 'galleries.'], function () {
        Route::resource('', 'GalleryController')->parameters(['' => 'gallery']);

        Route::delete('items/destroy', [
            'as'         => 'deletes',
            'uses'       => 'GalleryController@deletes',
            'permission' => 'galleries.destroy',
        ]);
    });
});

Route::group(apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []), function () {
    Route::get('galleries', [
        'as'   => 'public.galleries',
        'uses' => 'PublicController@getGalleries',
    ]);

    Route::get('gallery/{slug}', [
        'as'   => 'public.gallery',
        'uses' => 'PublicController@getGallery',
    ]);
});
