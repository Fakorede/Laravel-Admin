<?php

use Illuminate\Support\Facades\Route;

Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');

// Shared Routes
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('user', 'AuthController@user');
    Route::put('users/info', 'AuthController@updateInfo');
    Route::put('users/password', 'AuthController@updatePassword');
    Route::post('logout', 'AuthController@logout');
});

// Admin Routes
Route::group([
    'middleware' => ['auth:api', 'scope:admin'],
    'prefix' => 'admin',
    'namespace' => 'Admin',
], function () {
    Route::get('chart', 'DashboardController@chart');
    Route::post('upload', 'ImageController@upload');
    Route::get('export', 'OrderController@export');

    Route::apiResource('users', 'UserController');
    Route::apiResource('roles', 'RoleController');
    Route::apiResource('permissions', 'PermissionController')->only('index');
    Route::apiResource('products', 'ProductController');
    Route::apiResource('orders', 'OrderController')->only(['index', 'show']);
});

// Influencer Routes
Route::group([
    'prefix' => 'influencer',
    'namespace' => 'Influencer',
], function () {
    Route::get('products', 'ProductController@index');

    Route::group([
        'middleware' => ['auth:api', 'scope:influencer'],
    ], function() {
        
    });
});
