<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('placeholder/{height}/{width}/{color?}', function ($h, $w, $c = null) {
	return App\Facades\PlaceHolder::make($h, $w, $c)->response();
});


// foreach(File::glob(__DIR__ . '/backend/{**/*,*}.php', GLOB_BRACE) as $filename) include $filename;
