<?php

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

// API version 1
Route::prefix('v1')->group(function () {
    // Authentication needed routes
    Route::namespace('Api')->middleware('auth:api')->group(function () {
        // Gets current user info
        Route::get('me', 'ProfileController@index')->name('profile');
    });

    // Auth action routes
    Route::namespace('Auth')->prefix('auth')->group(function () {
        // Logs a user in
        Route::post('login', 'LoginController@login')->name('login');

        // Registers a user
        Route::post('sign-up', 'RegisterController@register')->name('sign-up');
    });
});
