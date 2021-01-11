<?php

use Illuminate\Support\Facades\Route;

Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');

// Admin
Route::group([
    'middleware' => ['auth:api', 'scope:admin'],
    'prefix' => 'admin',
    'namespace' => 'Admin',
], function () {
    Route::post('logout', 'AuthController@logout');

    Route::get('chart', 'DashboardController@chart');
    Route::get('user', 'UserController@user');
    Route::put('users/info', 'UserController@updateInfo');
    Route::put('users/password', 'UserController@updatePassword');
    Route::post('upload', 'ImageController@upload');
    Route::get('export', 'OrderController@export');

    Route::apiResource('users', 'UserController');
    Route::apiResource('roles', 'RoleController');
    Route::apiResource('permissions', 'PermissionController')->only('index');
    Route::apiResource('products', 'ProductController');
    Route::apiResource('orders', 'OrderController')->only(['index', 'show']);
});

// Influencer
Route::group([
    'prefix' => 'influencer',
    'namespace' => 'Influencer',
], function () {
    Route::get('products', 'ProductController@index');

    Route::group([
        'middleware' => ['auth:api', 'scope:influencer'],
    ], function () {
        Route::post('links', 'LinkController@store');
    });
});

// Checkout
Route::group([
    'prefix' => 'checkout',
    'namespace' => 'Checkout',
], function () {
    Route::get('links/{code}', 'LinkController@show');
});
