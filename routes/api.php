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

        // Get posts feed
        Route::get('feed', 'FeedController@index');

        // Gets current user info
        Route::get('me', 'ProfileController@index')->name('profile');
        Route::get('me/photos', 'ProfileController@myPhotos');

        // Get user profile by id
        Route::get('profile/{user}', 'ProfileController@profile');
        Route::get('profile/{user}/photos', 'ProfileController@photos');

        Route::get('profile/{user}/business-info', 'ProfileController@getBusinessInfo')->name('business-info');

        // Add business info for user
        Route::post('business', 'ProfileController@createBusinessInfo')->name('business');
        Route::put('business', 'ProfileController@updateBusinessInfo');

        // Cars routes
        Route::prefix('cars')->group(function () {
            // Get all of the user's cars
            Route::get('/', 'CarsController@getAll');
            Route::get('/user/{user}', 'CarsController@getAllForUser');

            // Get a certain car
            Route::get('{car}', 'CarsController@index')->name('show-car');

            Route::get('{car}/photos', 'CarsController@getCarPhotos');

            // Adds a car
            Route::post('/', 'CarsController@create')->name('car');

            // Updates a car
            Route::put('{car}', 'CarsController@update')->name('update-car');

            // Upload car's cover image and photo
            Route::post('{car}/cover', 'CarsController@uploadCover');
            Route::post('{car}/photo', 'CarsController@uploadPhoto');

            // Deletes a car
            Route::delete('{car}', 'CarsController@delete')->name('delete-car');

            // Mods routes
            Route::post('{car}/mods', 'CarsController@createMod');
            Route::get('{car}/mods', 'CarsController@getAllMods');
            Route::get('{car}/mods/{mod}', 'CarsController@getMod');
            Route::put('mods/{mod}', 'CarsController@updateMod');
            Route::delete('mods/{mod}', 'CarsController@deleteMod');
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
        Route::delete('photo/{image}', 'UsersController@deletePhoto');

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
