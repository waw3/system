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

    Route::group(['prefix' => 'custom-fields', 'as' => 'custom-fields.'], function () {

        Route::resource('', 'CustomFieldController')->parameters(['' => 'custom-field']);

        Route::delete('items/destroy', [
            'as'         => 'deletes',
            'uses'       => 'CustomFieldController@deletes',
            'permission' => 'custom-fields.destroy',
        ]);

        Route::get('export/{id?}', [
            'as'         => 'export',
            'uses'       => 'CustomFieldController@getExport',
            'permission' => 'custom-fields.index',
        ]);

        Route::post('import', [
            'as'         => 'import',
            'uses'       => 'CustomFieldController@postImport',
            'permission' => 'custom-fields.index',
        ]);
    });
});
