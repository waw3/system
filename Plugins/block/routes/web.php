<?php

Route::group(['namespace' => 'Modules\Plugins\Block\Http\Controllers', 'middleware' => 'web'], function () {
    Route::group(['prefix' => mconfig('base.config.admin_dir'), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'blocks', 'as' => 'block.'], function () {

            Route::resource('', 'BlockController')->parameters(['' => 'block']);

            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'BlockController@deletes',
                'permission' => 'block.destroy',
            ]);
        });
    });
});
