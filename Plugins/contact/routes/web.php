<?php

Route::group(['namespace' => 'Modules\Plugins\Contact\Http\Controllers', 'middleware' => 'web'], function () {
    Route::post('send-contact', [
        'as'   => 'public.send.contact',
        'uses' => 'PublicController@postSendContact',
    ]);

    Route::group(['prefix' => mconfig('base.config.admin_dir'), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'contacts', 'as' => 'contacts.'], function () {

            Route::resource('', 'ContactController')->except(['create', 'store'])->parameters(['' => 'contact']);

            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'ContactController@deletes',
                'permission' => 'contacts.destroy',
            ]);

            Route::post('reply/{id}', [
                'as'   => 'reply',
                'uses' => 'ContactController@postReply',
            ]);
        });
    });
});
