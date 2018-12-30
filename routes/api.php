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

Route::group(['prefix' => 'v1/user'], function() {
	Route::post('register', 'Auth\UserController@register');
	Route::post('login', 'Auth\UserController@login');
	Route::get('verify', 'Api\UserManageController@verifyUser');
	Route::get('password/reset/request', 'Api\ResetPasswordController@resetPasswordRequest');
	Route::post('password/reset', 'Api\ResetPasswordController@resetPassword');
	Route::get('search', 'Api\UserManageController@search');
});

Route::group(['middleware' => ['jwt.verify'], 'prefix' => 'v1/user'], function() {
	Route::get('logout', 'Auth\UserController@logout');
	Route::get('profile', 'Auth\UserController@profile');
	Route::get('auth', function() {
		return response()->json(['success' => true]);
	});
});

// demo crud
Route::group(['prefix' => 'v1'], function() {
	Route::get('person', 'Api\PersonController@index');
	Route::post('person', 'Api\PersonController@store');
	Route::get('person/{id}', 'Api\PersonController@show');
	Route::put('person/{id}', 'Api\PersonController@update');
	Route::delete('person/{id}', 'Api\PersonController@destroy');
});
