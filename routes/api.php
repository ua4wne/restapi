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

Route::post('login', 'Api\AuthController@login');

Route::group([
    'middleware' => 'auth:api'
], function () {
    Route::get('logout', 'Api\AuthController@logout');
    Route::get('user', 'Api\AuthController@user');
});

Route::fallback(function(){
    return response()->json(['message' => 'resourse not found'], 404);
})->name('api.fallback.404');

