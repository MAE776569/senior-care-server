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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::prefix('v1')->group(function(){
    Route::post('login', 'Api\AuthController@login');
    Route::post('register', 'Api\AuthController@register');
    Route::post('addpatient', 'Api\AuthController@addpatient');
    Route::get('emergency','Api\AuthController@addemergency');
    
    Route::group(['middleware' => 'auth:api'], function(){
     Route::post('getUser', 'Api\AuthController@getUser');
     Route::post('getpatients', 'Api\AuthController@getpatients');
     Route::post('getpatient', 'Api\AuthController@getpatient');
     Route::post('getemergency', 'Api\AuthController@getemergency');
     Route::post('gethistory', 'Api\AuthController@history');
     Route::post('confirmemergency', 'Api\AuthController@confirm');
     Route::post('addcomment','Api\AuthController@addcomment');
    });
    
    });