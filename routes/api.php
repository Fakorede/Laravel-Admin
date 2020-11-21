<?php

use Illuminate\Support\Facades\Route;

Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('user', 'UserController@user');
    Route::put('users/info', 'UserController@updateInfo');
    Route::put('users/password', 'UserController@updatePassword');
    Route::apiResource('users', 'UserController');
});
