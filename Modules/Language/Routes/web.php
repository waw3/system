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


Route::middleware(['auth'])->prefix(mconfig('base.config.admin_dir'))->group( function () {
    Route::prefix('settings/languages')->group( function () {
        Route::get('', 'LanguageController@index')->name('languages.index');
        Route::post('edit', 'LanguageController@update')->name('languages.edit');
        Route::delete('delete/{id}', 'LanguageController@destroy')->name('languages.destroy');

        Route::post('store', 'LanguageController@postStore')->permission('languages.create')->name('languages.store');
        Route::get('set-default', 'LanguageController@getSetDefault')->permission('languages.edit')->name('languages.set.default');
        Route::get('get', 'LanguageController@getLanguage')->permission('languages.edit')->name('languages.get');
        Route::post('edit-setting', 'LanguageController@postEditSettings')->permission('languages.edit')->name('languages.settings');
    });
});

Route::prefix('languages')->group( function () {
    Route::post('change-item-language', 'LanguageController@postChangeItemLanguage')->permission(false)->name('languages.change.item.language');
    Route::get('change-data-language/{locale}', 'LanguageController@getChangeDataLanguage')->permission(false)->name('languages.change.data.language');
});
