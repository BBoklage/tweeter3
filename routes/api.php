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

//List Posts
Route::get('posts', 'PostController@index');

//List Single Post
Route::get('post/{id}', 'PostController@show');

//create New Post
Route::post('post', 'PostController@store');

//Update Post
Route::put('post', 'PostController@store');

//Delete Post
Route::delete('post/{id}', 'PostController@destroy');