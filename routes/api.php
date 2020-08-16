<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('user')->group( function() {
    Route::post('/register','Auth\RegisterController@register');
    Route::post('/login','Auth\LoginController@login');
    Route::get('/me','Social\UserController@user');
    Route::get('/logout','Social\UserController@logout');
    Route::put('/update','Social\UserController@update');
    Route::patch('/update/password','Social\UserController@updatePassword');
});
/// Posts
Route::prefix('post')->group( function() {
    Route::get('/index', 'Social\PostController@index');
    Route::post('/store', 'Social\PostController@store');
    Route::get('/edit/{id}', 'Social\PostController@edit');
    Route::post('/update/{id}', 'Social\PostController@update');
    Route::delete('/delete/{id}', 'Social\PostController@destroy');
});
