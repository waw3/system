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

    Route::group(['prefix' => 'menus', 'as' => 'menus.'], function () {
        Route::resource('', 'MenuController')->parameters(['' => 'menu']);

        Route::delete('items/destroy', [
            'as'         => 'deletes',
            'uses'       => 'MenuController@deletes',
            'permission' => 'menus.destroy',
        ]);
    });
});
