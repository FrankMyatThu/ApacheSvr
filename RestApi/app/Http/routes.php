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
    //return view('welcome');
    return "Hello...";
});

Route::get('/hello', function () {
    return "this is hello ..";
});

Route::get('/test', function () {
    return "****";
});

Route::get('/product', array('as' => 'product', 'uses' => 'ProductController@SelectProductAll'));
Route::get('/product/{ProductName}', array('as' => 'product', 'uses' => 'ProductController@SelectProductByProductName'));


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
