<?php

use Illuminate\Support\Facades\Route;

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

// Public routes

Route::get('me', "User\MeController@getMe");

// Route group for authenticated users
Route::group([

    'middleware' => ['auth' => 'api'],

], function () {
    Route::post('logout', 'Auth\LoginController@logout');

});

// Route for guests only
Route::group([

    'middleware' => ['guest' => 'api'],

], function () {

    Route::post('register', 'Auth\RegisterController@register');
    Route::post('verification/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('verification/resend', 'Auth\VerificationController@resend');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('reset', 'Auth\ResetPasswordController@reset');
});
