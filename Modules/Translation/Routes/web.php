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

Route::middleware('auth')->prefix(mconfig('base.config.admin_dir'))->group( function () {
    Route::prefix('system/translations')->group( function () {
        Route::get('/', [
            'as'         => 'translations.index',
            'uses'       => 'TranslationController@getIndex',
            'permission' => 'translations.edit',
        ])->where('groupKey', '.*');

        Route::post('edit', [
            'as'         => 'translations.group.edit',
            'uses'       => 'TranslationController@update',
            'permission' => 'translations.edit',
        ])->where('groupKey', '.*');

        Route::post('add', [
            'as'         => 'translations.group.add',
            'uses'       => 'TranslationController@postAdd',
            'permission' => 'translations.create',
        ])->where('groupKey', '.*');

        Route::post('delete', [
            'as'         => 'translations.group.destroy',
            'uses'       => 'TranslationController@postDelete',
            'permission' => 'translations.destroy',
        ])->where('groupKey', '.*');

        Route::post('publish', [
            'as'         => 'translations.group.publish',
            'uses'       => 'TranslationController@postPublish',
            'permission' => 'translations.edit',
        ])->where('groupKey', '.*');

        Route::post('import', [
            'as'         => 'translations.import',
            'uses'       => 'TranslationController@postImport',
            'permission' => 'translations.edit',
        ]);

        Route::post('find', [
            'as'         => 'translations.find',
            'uses'       => 'TranslationController@postFind',
            'permission' => 'translations.create',
        ]);
    });
});
