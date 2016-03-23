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


Route::get('/order', array('as' => 'order', 'uses' => 'OrderController@SelectOrderAll'));
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
