<?php






Route::group(['namespace' => 'Modules\Plugins\Product\Http\Controllers', 'middleware' => 'web'], function () {

    Route::group(['prefix' => mconfig('base.config.admin_dir'), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
            Route::resource('', 'ProductController')->parameters(['' => 'product']);

            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'ProductController@deletes',
                'permission' => 'products.destroy',
            ]);

            Route::get('widgets/recent-products', [
                'as'         => 'widget.recent-products',
                'uses'       => 'ProductController@getWidgetRecentProducts',
                'permission' => 'products.index',
            ]);


        });



        Route::group(['prefix' => 'procategories', 'as' => 'procategories.'], function () {
            Route::resource('', 'ProCategoryController')->parameters(['' => 'procategory']);

            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'ProCategoryController@deletes',
                'permission' => 'procategories.destroy',
            ]);
        });




        Route::group(['prefix' => 'protags', 'as' => 'protags.'], function () {
            Route::resource('', 'ProTagController')->parameters(['' => 'protag']);

            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'ProTagController@deletes',
                'permission' => 'protags.destroy',
            ]);

            Route::get('all', [
                'as'         => 'all',
                'uses'       => 'ProTagController@getAllProTags',
                'permission' => 'protags.index',
            ]);
        });


         Route::group(['prefix' => 'features', 'as' => 'features.'], function () {
            Route::resource('', 'FeaturesController')->parameters(['' => 'features']);
            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'FeaturesController@deletes',
                'permission' => 'features.destroy',
            ]);
        });

        Route::group(['prefix' => 'stores', 'as' => 'store.'], function () {
            Route::resource('', 'StoreController')->parameters(['' => 'store']);
            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'StoreController@deletes',
                'permission' => 'store.destroy',
            ]);
        });

        Route::group(['prefix' => 'carts', 'as' => 'cart.'], function () {
            Route::resource('', 'CartController')->parameters(['' => 'cart']);
            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'CartController@deletes',
                'permission' => 'cart.destroy',
            ]);
        });

        Route::group(['prefix' => 'orderstatuses', 'as' => 'orderstatus.'], function () {
            Route::resource('', 'OrderstatusController')->parameters(['' => 'orderstatus']);
            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'OrderstatusController@deletes',
                'permission' => 'orderstatus.destroy',
            ]);
        });

        Route::group(['prefix' => 'payments', 'as' => 'payment.'], function () {
            Route::resource('', 'PaymentController')->parameters(['' => 'payment']);
            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'PaymentController@deletes',
                'permission' => 'payment.destroy',
            ]);
        });

         Route::group(['prefix' => 'shippings', 'as' => 'shipping.'], function () {
            Route::resource('', 'ShippingController')->parameters(['' => 'shipping']);
            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'ShippingController@deletes',
                'permission' => 'shipping.destroy',
            ]);
        });

    });

    if (defined('THEME_MODULE_SCREEN_NAME')) {
        Route::group(apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []), function () {
            Route::get('searchpro', [
                'as'   => 'public.searchpro',
                'uses' => 'PublicController@getSearchPro',
            ]);

            Route::get('protag/{slug}', [
                'as'   => 'public.protag',
                'uses' => 'PublicController@getProTag',
            ]);

            Route::get('/product_info', [
                'as'   => 'public.product_info',
                'uses' => 'CartController@getAllProductAjax',
            ]);

            /*Route::get('/tags', function() {
                return view('tags');
            });*/

            Route::get('/searchac', [
                'as'   => 'products.search',
                'uses' => 'CartController@search',
            ]);

            Route::post('/add_item', [
                'as'   => 'products.add_item',
                'uses' => 'CartController@postAddItem',
            ]);


        });
    }
});
