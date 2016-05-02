<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/', function () {
    return view('welcome');    
});

Route::post('/product/CreateProduct', array('as' => 'CreateProduct', 'uses' => 'ProductController@CreateProduct'));
Route::post('/product/SelectProductWithoutPager', array('as' => 'SelectProductWithoutPager', 'uses' => 'ProductController@SelectProductWithoutPager'));
Route::post('/product/SelectProductWithPager', array('as' => 'SelectProductWithPager', 'uses' => 'ProductController@SelectProductWithPager'));
Route::post('/product/UpdateProduct', array('as' => 'UpdateProduct', 'uses' => 'ProductController@UpdateProduct'));
Route::post('/product/DeleteProduct', array('as' => 'DeleteProduct', 'uses' => 'ProductController@DeleteProduct'));

Route::post('/order/SelectOrderDetail', array('as' => 'SelectOrderDetail', 'uses' => 'OrderController@SelectOrderDetail'));
Route::post('/order/SelectOrderWithPager', array('as' => 'SelectOrderWithPager', 'uses' => 'OrderController@SelectOrderWithPager'));
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
