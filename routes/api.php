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

Route::group(['prefix' => 'v1'], function() {
	Route::get('person', 'Api\PersonController@index');
	Route::post('person', 'Api\PersonController@store');
	Route::get('person/{id}', 'Api\PersonController@show');
	Route::patch('person/{id}', 'Api\PersonController@update');
	Route::delete('person/{id}', 'Api\PersonController@destroy');
});
