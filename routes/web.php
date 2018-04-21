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


Route::get('/', ['uses' => 'HomeController@index', 'as' => 'home']);

Route::get('/login', ['uses' => 'Auth\LoginController@login', 'as' => 'login.view']);
Route::post('/login', ['uses' => 'Auth\LoginController@doLogin', 'as' => 'login.do']);
Route::get('/auth/logout', ['uses' => 'Auth\LoginController@logout', 'as' => 'user.logout']);

Route::group(['prefix' => 'users'], function () {
    Route::get('/blog-users', ['uses' => 'UserController@index', 'as' => 'user.blog']);
    Route::get('/detail/{user_id}', ['uses' => 'UserController@detail', 'as' => 'user.blog.detail']);
    Route::post('/update-price', ['uses' => 'UserController@save_price', 'as' => 'user.blog.detail.update']);
    Route::post('/approve-user', ['uses' => 'UserController@approve_user', 'as' => 'user.blog.detail.approve']);
    Route::post('/update-fanpage', ['uses' => 'UserController@update_fanpage', 'as' => 'user.blog.fanpage.update']);
    Route::get('/{user_id}', ['uses' => 'UserController@user_details', 'as' => 'user.blog.detail']);
    Route::get('/detail/{user_id}', ['uses' => 'UserController@user_details_info', 'as' => 'user.blog.detail.info']);
});
Route::group(['prefix' => 'blog'], function () {
    Route::get('/blog-share', ['uses' => 'BlogController@index', 'as' => 'blog.user.share']);
    Route::get('/blog-detail/{id}', ['uses' => 'BlogController@details', 'as' => 'blog.user.share.details']);
    Route::post('/update-campaign', ['uses' => 'BlogController@update_post_campaign', 'as' => 'blog.campaign']);
    Route::get('/posts-from-blog', ['uses' => 'BlogController@get_post_from_blog', 'as' => 'blog.posts']);

});

Route::group(['prefix' => 'socials'], function () {
    Route::get('/', ['uses' => 'SocialController@index', 'as' => 'social.network']);
    Route::post('/update', ['uses' => 'SocialController@update', 'as' => 'social.network.update']);

});

Route::group(['prefix' => 'profile'], function () {

    Route::get('/', ['uses' => 'ProfileController@index', 'as' => 'profile.user']);
    Route::post('/update', ['uses' => 'ProfileController@user_update', 'as' => 'profile.user.update']);
    Route::get('/change-password', ['uses' => 'ProfileController@change_password', 'as' => 'profile.change.password']);
    Route::post('/change-password', ['uses' => 'ProfileController@do_change_password', 'as' => 'profile.do.change.password']);
});