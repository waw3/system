<?php

Route::group(['namespace' => 'Modules\Plugins\Impersonate\Http\Controllers', 'middleware' => 'web'], function () {

    Route::group(['prefix' => config('core.base.config.admin_dir'), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'impersonates'], function () {

            Route::get('impersonate/{id}', [
                'as'         => 'users.impersonate',
                'uses'       => 'ImpersonateController@getImpersonate',
                'permission' => 'superuser',
            ]);

            Route::get('leave-impersonation', [
                'as'         => 'users.leave_impersonation',
                'uses'       => 'ImpersonateController@leaveImpersonation',
                'permission' => false,
            ]);

        });
    });

});
