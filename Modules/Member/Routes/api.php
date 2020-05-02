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


Route::prefix('v1')->group( function () {

    Route::post('register', 'AuthenticationController@register');
    Route::post('login', 'AuthenticationController@login');

    Route::post('password/forgot', 'ForgotPasswordController@sendResetLinkEmail');

    Route::post('verify-account', 'VerificationController@verify');
    Route::post('resend-verify-account-email', 'VerificationController@resend');

    Route::middleware(['auth:member-api'])->group( function () {
        Route::get('logout', 'AuthenticationController@logout');
        Route::get('me', 'MemberController@getProfile');
        Route::put('me', 'MemberController@updateProfile');
        Route::post('update-avatar', 'MemberController@updateAvatar');
        Route::put('change-password', 'MemberController@updatePassword');
    });

});
