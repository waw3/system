<?php

Route::group(['namespace' => 'Modules\Plugins\Payment\Http\Controllers', 'middleware' => 'web'], function () {
    Route::group(['prefix' => 'payments'], function () {
        Route::post('checkout', 'PaymentController@postCheckout')->name('payments.checkout');

        Route::get('status', 'PaymentController@getPayPalStatus')->name('payments.paypal.status');
    });

    Route::group(['prefix' => mconfig('base.config.admin_dir'), 'middleware' => 'auth'], function () {
        Route::group(['prefix' => 'payments'], function () {
            Route::get('methods', [
                'as'   => 'payments.methods',
                'uses' => 'PaymentController@methods',
            ]);

            Route::post('methods', [
                'as'         => 'payments.methods',
                'uses'       => 'PaymentController@updateMethods',
                'middleware' => 'preventDemo',
            ]);

            Route::post('methods/update-status', [
                'as'         => 'payments.methods.update.status',
                'uses'       => 'PaymentController@updateMethodStatus',
                'permission' => 'payment.methods',
            ]);
        });

        Route::group(['prefix' => 'payments', 'as' => 'payment.'], function () {
            Route::resource('', 'PaymentController')->parameters(['' => 'payment'])->only(['index', 'destroy']);
            Route::get('view/{chargeId}', 'PaymentController@show')->name('show');

            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'PaymentController@deletes',
                'permission' => 'payment.destroy',
            ]);
        });

    });
});
