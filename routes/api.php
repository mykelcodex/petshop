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

Route::group(['prefix' => 'v1', 'middleware'=>'json.response'], function (){ 

	Route::get('/main/blogs', 'MainController@getPosts');
	Route::get('/main/blog/{uuid}', 'MainController@getPost');
	Route::get('/main/promotions', 'MainController@getPromotions');

});


Route::group(['prefix' => 'v1/admin', 'namespace' => 'Admin', 'middleware'=>'json.response'], function (){ 
    Route::post('/login', 'AuthController@login');
    Route::get('/logout', 'AuthController@logout');
    Route::post('/create', 'UserController@create');
    Route::get('/user-listing', 'UserController@userListing');
});


Route::group(['prefix' => 'v1', 'namespace' => 'Admin', 'middleware'=>'json.response'], function (){ 
	//Brand
	Route::get('/brands', 'BrandController@getBrands');
	Route::post('/brand/create', 'BrandController@create');
	Route::put('/brand/{uuid}', 'BrandController@edit');
	Route::delete('/brand/{uuid}', 'BrandController@delete');
	Route::get('/brand/{uuid}', 'BrandController@getBrand');

	//Category
	Route::get('/categories', 'CategoryController@getCategories');
	Route::post('/category/create', 'CategoryController@create');
	Route::put('/category/{uuid}', 'CategoryController@edit');
	Route::delete('/category/{uuid}', 'CategoryController@delete');
	Route::get('/category/{uuid}', 'CategoryController@getCategory');

	//Orders
	Route::get('/orders', 'OrderController@getOrders');
	Route::post('/order/create', 'OrderController@create');
	Route::get('/order/{uuid}', 'OrderController@getOrder');
	Route::patch('/order/{uuid}', 'OrderController@edit');
	Route::delete('/order/{uuid}', 'OrderController@delete');
	Route::get('/order/{uuid}/download', 'OrderController@download');

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
