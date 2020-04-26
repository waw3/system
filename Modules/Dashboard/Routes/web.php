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

    Route::get('', [
        'uses'       => 'DashboardController@getDashboard',
        'permission' => false,
    ])->name('dashboard.index');

    Route::group(['prefix' => 'widgets', 'permission' => false], function () {
        Route::get('hide', [
            'as'   => 'dashboard.hide_widget',
            'uses' => 'DashboardController@getHideWidget',
        ]);

        Route::post('hides', [
            'as'   => 'dashboard.hide_widgets',
            'uses' => 'DashboardController@postHideWidgets',
        ]);

        Route::post('order', [
            'as'   => 'dashboard.update_widget_order',
            'uses' => 'DashboardController@postUpdateWidgetOrder',
        ]);

        Route::post('setting-item', [
            'as'   => 'dashboard.edit_widget_setting_item',
            'uses' => 'DashboardController@postEditWidgetSettingItem',
        ]);
    });
});

