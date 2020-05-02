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

Route::middleware(['auth'])->prefix(mconfig('base.config.admin_dir'))->group( function () {

    Route::prefix('members')->name('member.')->group( function () {

        Route::resource('', 'MemberController')->parameters(['' => 'member']);

        Route::delete('items/destroy', [
            'as'         => 'deletes',
            'uses'       => 'MemberController@deletes',
            'permission' => 'member.destroy',
        ]);
    });
});

if (defined('THEME_MODULE_SCREEN_NAME')) {
    Route::group(apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []), function () {

        Route::name('public.member.')->group( function () {

            Route::middleware(['member.guest'])->group( function () {
                Route::get('login', 'LoginController@showLoginForm')->name('login');
                Route::post('login', 'LoginController@login')->name('login.post');
                Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
                Route::post('register', 'RegisterController@register')->name('register.post');
                Route::get('verify', 'RegisterController@getVerify')->name('verify');
                Route::get('password/request','ForgotPasswordController@showLinkRequestForm')->name('password.request');
                Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
                Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');
                Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
            });

            Route::middleware([mconfig('member.general.verify_email') ? 'member.guest' : 'member'])->group( function () {
                Route::get('register/confirm/resend','RegisterController@resendConfirmation')->name('resend_confirmation');
                Route::get('register/confirm/{email}', 'RegisterController@confirm')->name('confirm');
            });

            Route::middleware(['member'])->group( function () {

                Route::prefix('account')->group( function () {
                    Route::post('logout', 'LoginController@logout')->name('logout');
                    Route::get('dashboard', 'PublicController@getDashboard')->name('dashboard');
                    Route::get('settings', 'PublicController@getSettings')->name('settings');
                    Route::post('settings', 'PublicController@postSettings')->name('post.settings');
                    Route::get('security', 'PublicController@getSecurity')->name('security');
                    Route::put('security', 'PublicController@postSecurity')->name('post.security');
                    Route::post('avatar', 'PublicController@postAvatar')->name('avatar');
                });

                Route::prefix('ajax/members')->group( function () {
                    Route::get('activity-logs', 'PublicController@getActivityLogs')->name('activity-logs');
                    Route::post('upload', 'PublicController@postUpload')->name('upload');
                    Route::delete('delete/{id}', 'PostController@delete')->name('posts.destroy');
                    Route::get('tags/all', 'PostController@getAllTags')->name('tags.all');
                });

                Route::prefix('account/posts')->group( function () {
                    Route::get('', 'PostController@index')->name('posts.index');
                    Route::get('create', 'PostController@create')->name('posts.create');
                    Route::post('create', 'PostController@store')->name('posts.create');
                    Route::get('edit/{id}', 'PostController@edit')->name('posts.edit');
                    Route::post('edit/{id}', 'PostController@update')->name('posts.edit');

                });
            });

        });

    });
}
