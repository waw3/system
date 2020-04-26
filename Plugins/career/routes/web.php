<?php

Route::group(['namespace' => 'Modules\Plugins\Career\Http\Controllers', 'middleware' => 'web'], function () {

    Route::group(['prefix' => mconfig('base.config.admin_dir'), 'middleware' => 'auth'], function () {

        Route::resource('careers', 'CareerController', ['names' => 'career']);

        Route::group(['prefix' => 'careers'], function () {

            Route::delete('items/destroy', [
                'as'         => 'career.deletes',
                'uses'       => 'CareerController@deletes',
                'permission' => 'career.destroy',
            ]);
        });
    });

});
