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
});

Route::group(['middleware' => ['jwt.auth'], 'prefix' => 'v1/user'], function() {
	Route::get('logout', 'Auth\UserController@logout');
	Route::get('auth', 'Auth\UserController@authTest');
});

Route::group(['prefix' => 'v1/user'], function() {
	Route::get('verify/{verification_code}', 'Auth\UserManageController@verifyUser');
	Route::post('password/reset', 'Auth\UserManageController@resetPassword');
});


// demo crud
Route::group(['prefix' => 'v1'], function() {
	Route::get('person', 'Api\PersonController@index');
	Route::post('person', 'Api\PersonController@store');
	Route::get('person/{id}', 'Api\PersonController@show');
	Route::put('person/{id}', 'Api\PersonController@update');
	Route::delete('person/{id}', 'Api\PersonController@destroy');
});
