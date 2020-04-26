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

use Modules\Acl\Http\Controllers\Auth\ForgotPasswordController;
use Modules\Acl\Http\Controllers\Auth\LoginController;
use Modules\Acl\Http\Controllers\Auth\ResetPasswordController;
use Modules\Acl\Http\Controllers\UserController;


Route::group(['prefix' => mconfig('base.config.admin_dir')], function () {
    Route::group(['middleware' => 'guest'], function () {

        Route::get('login', [LoginController::class, 'showLoginForm'])
            ->name('access.login');
        Route::post('login', [LoginController::class, 'login'])
            ->name('access.login');

        Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])
            ->name('access.password.request');
        Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])
            ->name('access.password.email');

        Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])
            ->name('access.password.reset');
        Route::post('password/reset', [ResetPasswordController::class, 'reset'])
            ->name('access.password.reset.post');
    });

    Route::group(['middleware' => 'auth'], function () {
        Route::get('logout', [
            'as'         => 'access.logout',
            'uses'       => 'Auth\LoginController@logout',
            'permission' => false,
        ]);
    });
});

Route::group(['prefix' => mconfig('base.config.admin_dir'), 'middleware' => 'auth'], function () {

    Route::group(['prefix' => 'system'], function () {
        Route::resource('users', 'UserController')->except(['edit', 'update']);

        Route::group(['prefix' => 'users'], function () {

            Route::delete('items/destroy', [
                'as'         => 'users.deletes',
                'uses'       => 'UserController@deletes',
                'permission' => 'users.destroy',
                'middleware' => 'preventDemo',
            ]);

            Route::post('update-profile/{id}', [
                'as'         => 'users.update-profile',
                'uses'       => 'UserController@postUpdateProfile',
                'permission' => false,
                'middleware' => 'preventDemo',
            ]);

            Route::post('modify-profile-image/{id}', [
                'as'         => 'users.profile.image',
                'uses'       => 'UserController@postAvatar',
                'permission' => false,
            ]);

            Route::post('change-password/{id}', [
                'as'         => 'users.change-password',
                'uses'       => 'UserController@postChangePassword',
                'permission' => false,
                'middleware' => 'preventDemo',
            ]);

            Route::get('profile/{id}', [
                'as'         => 'user.profile.view',
                'uses'       => 'UserController@getUserProfile',
                'permission' => false,
            ]);

            Route::get('make-super/{id}', [
                'as'         => 'users.make-super',
                'uses'       => 'UserController@makeSuper',
                'permission' => 'superuser',
            ]);

            Route::get('remove-super/{id}', [
                'as'         => 'users.remove-super',
                'uses'       => 'UserController@removeSuper',
                'permission' => 'superuser',
                'middleware' => 'preventDemo',
            ]);
        });

        Route::resource('roles', 'RoleController');

        Route::group(['prefix' => 'roles'], function () {
            Route::delete('items/destroy', [
                'as'         => 'roles.deletes',
                'uses'       => 'RoleController@deletes',
                'permission' => 'roles.destroy',
            ]);

            Route::get('duplicate/{id}', [
                'as'         => 'roles.duplicate',
                'uses'       => 'RoleController@getDuplicate',
                'permission' => 'roles.create',
            ]);

            Route::get('json', [
                'as'         => 'roles.list.json',
                'uses'       => 'RoleController@getJson',
                'permission' => 'roles.index',
            ]);

            Route::post('assign', [
                'as'         => 'roles.assign',
                'uses'       => 'RoleController@postAssignMember',
                'permission' => 'roles.edit',
            ]);
        });
    });

});

Route::get('admin-theme/{theme}', [UserController::class, 'getTheme'])->name('admin.theme');

