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
    Route::get('user-price', ['uses' => 'APIBlogUserController@get_price_user', 'as' => 'user.price']);
});

Route::post('save-token', ['uses' => 'APIBlogUserController@save_token', 'as' => 'user.token']);
   
