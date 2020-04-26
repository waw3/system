<?php

Route::group(['namespace' => 'Modules\Plugins\Comments\Http\Controllers', 'middleware' => 'web'], function () {

    Route::group(['prefix' => mconfig('base.config.admin_dir'), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'comments', 'as' => 'comments.'], function () {
            Route::resource('', 'CommentsController')->parameters(['' => 'comments']);
            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'CommentsController@deletes',
                'permission' => 'comments.destroy',
            ]);
        });
    });

});
