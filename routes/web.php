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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', ['uses' => 'Auth\LoginController@login_view', 'as' => 'login.view']);

Route::group(['prefix' => 'users'], function () {
    Route::get('/blog-users', ['uses' => 'UserController@index', 'as' => 'user.blog']);
    Route::get('/detail/{user_id}', ['uses' => 'UserController@detail', 'as' => 'user.blog.detail']);
    Route::post('/update-price', ['uses' => 'UserController@save_price', 'as' => 'user.blog.detail.update']);
    //Route::post('/approve-user', ['uses' => 'UserController@approve_user', 'as' => 'user.blog.detail.approve']);
    Route::get('/approve-user', ['uses' => 'UserController@approve_user', 'as' => 'user.blog.detail.approve']);
});

Route::group(['prefix' => 'socials'], function () {
    Route::get('/', ['uses' => 'SocialController@index', 'as' => 'social.network']);
    Route::post('/update', ['uses' => 'SocialController@update', 'as' => 'social.network.update']);

});