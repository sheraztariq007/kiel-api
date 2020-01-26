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

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');

Route::group(['middleware' => 'auth:api'], function(){

    Route::post('details', 'API\UserController@details');
    Route::prefix('trip')->group(function () {
        Route::get('me','API\TripController@index');
        Route::post('store','API\TripController@store');

        Route::post('{id}/edit','API\TripController@edit');

        Route::post('{id}/update','API\TripController@update');
        Route::post('{id}/delete','API\TripController@delete');
//        Route::get('plan', function () {
//            // Matches The "/admin/users" URL
//        });
    });
});