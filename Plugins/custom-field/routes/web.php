<?php

Route::group(['namespace' => 'Modules\Plugins\CustomField\Http\Controllers', 'middleware' => 'web'], function () {
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
});
