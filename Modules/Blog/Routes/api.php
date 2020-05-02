<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('search', 'PostController@getSearch')->name('public.api.search');
Route::get('posts', 'PostController@index');
Route::get('categories', 'CategoryController@index');
Route::get('tags', 'TagController@index');

Route::get('posts/filters', 'PostController@getFilters');
Route::get('posts/{slug}', 'PostController@findBySlug');
Route::get('categories/filters', 'CategoryController@getFilters');
Route::get('categories/{slug}', 'CategoryController@findBySlug');
