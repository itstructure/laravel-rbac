<?php

use Illuminate\Support\Facades\Route;
use Itstructure\LaRbac\Http\Controllers\{UserController, RoleController, PermissionController};

/*
 * RBAC Admin section to administrate members.
 */
Route::group([
        'prefix' => 'rbac',
        'middleware' => array_merge(
            is_array(config('rbac.routesAuthMiddlewares')) ? config('rbac.routesAuthMiddlewares') : ['auth'],
            !empty(config('rbac.routesMainPermission')) ? ['can:'.config('rbac.routesMainPermission')] : []
        )
    ], function () {

    // Users (members)
    Route::group(['prefix' => 'users'], function () {

        Route::get('/', [UserController::class, 'index'])
            ->name('list_users');

        Route::get('show/{id}', [UserController::class, 'show'])
            ->name('show_user');

        Route::get('edit/{id}', [UserController::class, 'edit'])
            ->name('edit_user');

        Route::post('update/{id}', [UserController::class, 'update'])
            ->name('update_user');

        Route::post('delete', [UserController::class, 'delete'])
            ->name('delete_user');
    });

    // Roles
    Route::group(['prefix' => 'roles'], function () {

        Route::get('/', [RoleController::class, 'index'])
            ->name('list_roles');

        Route::get('show/{id}', [RoleController::class, 'show'])
            ->name('show_role');

        Route::get('create', [RoleController::class, 'create'])
            ->name('create_role');

        Route::get('edit/{role}', [RoleController::class, 'edit'])
            ->name('edit_role');

        Route::post('store', [RoleController::class, 'store'])
            ->name('store_role');

        Route::post('update/{role}', [RoleController::class, 'update'])
            ->name('update_role');

        Route::post('/delete', [RoleController::class, 'delete'])
            ->name('delete_role');
    });

    // Permissions
    Route::group(['prefix' => 'permissions'], function () {

        Route::get('/', [PermissionController::class, 'index'])
            ->name('list_permissions');

        Route::get('show/{id}', [PermissionController::class, 'show'])
            ->name('show_permission');

        Route::get('create', [PermissionController::class, 'create'])
            ->name('create_permission');

        Route::get('edit/{permission}', [PermissionController::class, 'edit'])
            ->name('edit_permission');

        Route::post('store', [PermissionController::class, 'store'])
            ->name('store_permission');

        Route::post('update/{permission}', [PermissionController::class, 'update'])
            ->name('update_permission');

        Route::post('delete', [PermissionController::class, 'delete'])
            ->name('delete_permission');
    });
});
