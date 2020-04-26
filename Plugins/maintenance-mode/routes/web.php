<?php

Route::group(['namespace' => 'Modules\Plugins\MaintenanceMode\Http\Controllers', 'middleware' => 'web'], function () {

    Route::group(['prefix' => config('core.base.config.admin_dir'), 'middleware' => 'auth'], function () {
        Route::group(['prefix' => 'system/maintenance'], function () {
            Route::get('', [
                'as'         => 'system.maintenance.index',
                'uses'       => 'MaintenanceModeController@getIndex',
                'permission' => 'superuser',
            ]);

            Route::post('run', [
                'as'         => 'system.maintenance.run',
                'uses'       => 'MaintenanceModeController@postRun',
                'middleware' => 'preventDemo',
                'permission' => 'superuser',
            ]);
        });
    });

});
