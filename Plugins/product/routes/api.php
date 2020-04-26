<?php

Route::group([
    'middleware' => 'api',
    'prefix'     => 'api/v1',
    'namespace'  => 'Modules\Plugins\Product\Http\Controllers\API',
], function () {

    Route::get('searchpro', 'ProductController@getSearchPro')->name('public.api.searchpro');
    Route::get('products', 'ProductController@index');
    Route::get('procategories', 'ProCategoryController@index');
    Route::get('features', 'FeaturesController@index');
    Route::get('protags', 'ProTagController@index');

    Route::get('products/filters', 'ProductController@getFilters');
    Route::get('products/{slug}', 'ProductController@findBySlug');
    Route::get('procategories/filters', 'ProCategoryController@getFilters');
    Route::get('procategories/{slug}', 'ProCategoryController@findBySlug');
    Route::get('features/filters', 'FeaturesController@getFilters');
    Route::get('features/{slug}', 'FeaturesController@findBySlug');

});
