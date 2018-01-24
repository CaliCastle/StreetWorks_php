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
    // Authenticated routes
    Route::namespace('Api')->middleware('auth:api')->group(function () {
        // Gets current user info
        Route::get('me', 'ProfileController@index')->name('profile');

        // Get user profile by id
        Route::get('profile/{user}', 'ProfileController@profile');

        Route::get('profile/{user}/business-info', 'ProfileController@getBusinessInfo')->name('business-info');

        // Add business info for user
        Route::post('business', 'ProfileController@createBusinessInfo')->name('business');
        Route::put('business', 'ProfileController@updateBusinessInfo');

        // Cars routes
        Route::prefix('cars')->group(function () {
            Route::get('{car}', 'CarsController@index')->name('show-car');

            // Adds a car
            Route::post('/', 'CarsController@create')->name('car');

            // Updates a car
            Route::put('{car}', 'CarsController@update')->name('update-car');

            // Deletes a car
            Route::delete('{car}', 'CarsController@delete')->name('delete-car');
        });

        // Profile routes
        Route::prefix('profile')->group(function () {
            // Update user's profile
            Route::put('/', 'ProfileController@updateProfile')->name('update-profile');

            // Upload user's avatar
            Route::post('avatar', 'ProfileController@uploadAvatar')->name('upload-avatar');

            // Upload user's cover photo
            Route::post('cover', 'ProfileController@uploadCoverImage');

            // Change user's password
            Route::put('password', 'ProfileController@changePassword')->name('password');
        });

        // Posts routes
        Route::prefix('posts')->group(function () {
            // Create a post
            Route::post('/', 'PostsController@create')->name('posts');

            // Get a post
            Route::get('{post}', 'PostsController@show')->name('post');

            // Comment on a post
            Route::post('{post}/comments', 'PostsController@comment')->name('comment-post');

            // Like a post
            Route::put('{post}', 'PostsController@likeOrUnlike');
        });

        // Upload a photo
        Route::post('photo', 'UsersController@uploadPhoto')->name('upload-photo');

        // Set avatar to facebook profile pic
        Route::post('avatar-facebook', 'ProfileController@useFacebookAvatar');
    });

    // Auth action routes
    Route::namespace('Auth')->prefix('auth')->group(function () {
        // Logs a user in
        Route::post('login', 'LoginController@login')->name('login');

        // Registers a user
        Route::post('sign-up', 'RegisterController@register')->name('sign-up');

        // Registers using Facebook
        Route::post('facebook', 'RegisterController@registerUsingFacebook');
    });
});
