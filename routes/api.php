<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Account
Route::post('account/registration', 'Api\AccountRegistrationController@registration');
Route::post('account/update', 'Api\AccountRegistrationController@update');
Route::get('account/show', 'Api\AccountRegistrationController@show');
Route::get('account/find', 'Api\AccountRegistrationController@find');

//Login
Route::post('login/registration', 'Api\LoginRegistrationController@registration');
Route::post('login/update', 'Api\LoginRegistrationController@update');
