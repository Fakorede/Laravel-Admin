<?php

use Illuminate\Support\Facades\Route;

Route::post('login', 'AuthController@login');
Route::apiResource('users', 'UserController');
