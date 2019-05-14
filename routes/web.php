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
    Route::get('/home', 'HomeController@index');
    //users/ группа обработки роутов users
    Route::group(['prefix'=>'users'], function(){
        Route::get('/',['uses'=>'UserController@index','as'=>'users']);
        //users/add
        Route::match(['get','post'],'/add',['uses'=>'UserController@create','as'=>'userAdd']);
        //users/edit
        //Route::match(['get','post','delete'],'/edit/{id}',['uses'=>'UserController@edit','as'=>'userEdit']);
        //users/reset
        Route::get('/reset/{id}',['uses'=>'UserController@resetPass','as'=>'userReset']);
        //users/ajax/edit
        Route::post('/ajax/edit',['uses'=>'Ajax\UserController@switchLogin','as'=>'switchLogin']);
        //users/ajax/edit_login
        Route::post('/ajax/edit_login',['uses'=>'Ajax\UserController@editLogin','as'=>'editLogin']);
        //users/ajax/delete
        Route::post('/ajax/delete',['uses'=>'Ajax\UserController@delete','as'=>'deleteLogin']);
    });
    //devices/ группа обработки роутов devices
    Route::group(['prefix'=>'devices'], function(){
        Route::get('/',['uses'=>'DeviceController@index','as'=>'devices']);
        //devices/add
        Route::match(['get','post'],'/add',['uses'=>'DeviceController@create','as'=>'deviceAdd']);
        //devices/edit
        //Route::match(['get','post','delete'],'/edit/{id}',['uses'=>'DeviceController@edit','as'=>'deviceEdit']);
        //devices/ajax/edit
        Route::post('/ajax/edit',['uses'=>'Ajax\DeviceController@edit','as'=>'editDevice']);
        //devices/ajax/delete
        Route::post('/ajax/delete',['uses'=>'Ajax\DeviceController@delete','as'=>'deleteDevice']);
    });
    //eventlog/ группа обработки роутов eventlog
    Route::group(['prefix'=>'eventlog'], function(){
        Route::get('/',['uses'=>'EventlogController@index','as'=>'logs']);
        //eventlog/ajax/delete
        Route::post('/ajax/delete',['uses'=>'Ajax\EventlogController@delete','as'=>'deleteLog']);
        //eventlog/ajax/delone
        Route::post('/ajax/delone',['uses'=>'Ajax\EventlogController@delone','as'=>'delOnelog']);
    });
    //params/ группа обработки роутов params
    Route::group(['prefix'=>'params'], function(){
        Route::get('/',['uses'=>'ParamController@index','as'=>'params']);
        //params/add
        Route::match(['get','post'],'/add',['uses'=>'ParamController@create','as'=>'paramAdd']);
        //params/edit
        //Route::match(['get','post','delete'],'/edit/{id}',['uses'=>'ParamController@edit','as'=>'paramEdit']);
        //params/ajax/add
        Route::post('/ajax/add',['uses'=>'Ajax\ParamController@create','as'=>'addParam']);
        //params/ajax/edit
        Route::post('/ajax/edit',['uses'=>'Ajax\ParamController@edit','as'=>'editParam']);
        //params/ajax/delete
        Route::post('/ajax/delete',['uses'=>'Ajax\ParamController@delete','as'=>'deleteParam']);
    });
});

Auth::routes();


