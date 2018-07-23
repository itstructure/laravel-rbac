<?php

use \Illuminate\Support\Facades\Route;
use Itstructure\LaRbac\Models\Permission;

/*
 * RBAC admin section
 */
Route::group([
        'prefix' => 'rbac',
        'middleware' => [
            'auth',
            'can:'.Permission::ADMIN_PERMISSION
        ]
    ], function () {

    // Roles
    Route::group(['prefix' => 'roles'], function () {

        Route::get('/', 'RoleController@index')
            ->name('list_roles');

        Route::get('/show/{id}', 'RoleController@show')
            ->name('show_role');

        Route::get('/create', 'RoleController@create')
            ->name('create_role');

        Route::post('/store', 'RoleController@store')
            ->name('store_role');

        Route::get('/edit/{role}', 'RoleController@edit')
            ->name('edit_role');

        Route::post('/update/{role}', 'RoleController@update')
            ->name('update_role');

        Route::post('/delete', 'RoleController@delete')
            ->name('delete_role');
    });

    // Permissions
    Route::group(['prefix' => 'permissions'], function () {

        Route::get('/', 'PermissionController@index')
            ->name('list_permissions');

        Route::get('/show/{id}', 'PermissionController@show')
            ->name('show_permission');

        Route::get('/create', 'PermissionController@create')
            ->name('create_permission');

        Route::post('/store', 'PermissionController@store')
            ->name('store_permission');

        Route::get('/edit/{permission}', 'PermissionController@edit')
            ->name('edit_permission');

        Route::post('/update/{permission}', 'PermissionController@update')
            ->name('update_permission');

        Route::post('/delete', 'PermissionController@delete')
            ->name('delete_permission');
    });

    // Users
    Route::group(['prefix' => 'users'], function () {

        Route::get('/', 'UserController@index')
            ->name('list_users');

        Route::get('/show/{id}', 'UserController@show')
            ->name('show_user');

        Route::get('/edit/{id}', 'UserController@edit')
            ->name('edit_user');

        Route::post('/update/{id}', 'UserController@update')
            ->name('update_user');

        Route::post('/delete', 'UserController@delete')
            ->name('delete_user');
    });
});
