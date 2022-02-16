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


Route::group(['prefix' => 'v1/admin', 'namespace' => 'Admin', 'middleware'=>'json.response'], function (){ 
    Route::post('/login', 'AuthController@login');
    Route::get('/logout', 'AuthController@logout');
    Route::post('/create', 'UserController@create');
    Route::get('/user-listing', 'UserController@userListing');
});

Route::group(['prefix' => 'v1/user', 'namespace' => 'User', 'middleware'=>'json.response'], function (){ 
    Route::post('/login', 'AuthController@login');
    Route::get('/logout', 'AuthController@logout');
    Route::post('/forgot-password', 'AuthController@forgotPassword');
    Route::post('/reset-password-token', 'AuthController@resetPassword');
    Route::get('/', 'UserController@getUser');
    Route::delete('/', 'UserController@deleteUser');
    Route::put('/edit', 'UserController@editUser');
    Route::get('/orders', 'OrderController@getOrders');

});
