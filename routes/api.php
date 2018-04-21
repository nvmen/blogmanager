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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

//Route::group(['middleware' => 'jwt.auth'], function () {
Route::group([], function () {
    Route::post('user-price', ['uses' => 'APIBlogUserController@get_price_user', 'as' => 'user.price']);
    Route::post('tracking-share', ['uses' => 'APIBlogUserController@add_tracking_user_share_post', 'as' => 'user.tracking.share.post']);
    Route::get('list-share-post', ['uses' => 'APIBlogUserController@get_sharing_by_user', 'as' => 'user.list.share.post']);
    Route::post('user-info', ['uses' => 'APIBlogUserController@get_user_info', 'as' => 'user.info']);
    Route::get('test', ['uses' => 'APIBlogUserController@test', 'as' => 'user.test']);
	Route::post('can-share', ['uses' => 'APIBlogUserController@canshare', 'as' => 'user.canshare']);

});

Route::post('save-token', ['uses' => 'APIBlogUserController@save_token', 'as' => 'user.token']);
    
