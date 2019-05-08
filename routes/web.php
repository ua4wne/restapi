<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
//activate
Route::get('/activate','Auth\LoginController@activate');

Route::middleware(['auth'])->group(function(){
    Route::get('/', 'HomeController@index')->name('home');
    //users/ группа обработки роутов users
    Route::group(['prefix'=>'users'], function(){
        Route::get('/',['uses'=>'UserController@index','as'=>'users']);
        //users/add
        Route::match(['get','post'],'/add',['uses'=>'UserController@create','as'=>'userAdd']);
        //users/edit
        Route::match(['get','post','delete'],'/edit/{id}',['uses'=>'UserController@edit','as'=>'userEdit']);
        //users/reset
        Route::get('/reset/{id}',['uses'=>'UserController@resetPass','as'=>'userReset']);
        //users/ajax/edit
        Route::post('/ajax/edit',['uses'=>'Ajax\UserController@switchLogin','as'=>'switchLogin']);
        //users/ajax/edit_login
        Route::post('/ajax/edit_login',['uses'=>'Ajax\UserController@editLogin','as'=>'editLogin']);
        //users/ajax/delete
        Route::post('/ajax/delete',['uses'=>'Ajax\UserController@delete','as'=>'deleteLogin']);
    });
});

Auth::routes();


