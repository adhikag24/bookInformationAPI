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



Route::group([
    'prefix' => 'auth'
], function ($router) {
    Route::post('register', 'UserController@register');
    Route::post('login', 'UserController@authenticate');
});

//routes group below are open to public, no need Admin Authentication.
Route::group([
    'prefix' => 'book'
], function ($router) {
    Route::get('list', 'BookController@index');
    Route::get('detail/{id}', 'BookController@show');
    Route::post('filter/{whatToFilter}', 'BookController@filter');
});

Route::group([
    'prefix' => 'admin'
], function ($router) {
    Route::post('book/create', 'BookController@store');
    Route::put('book/update/{id}', 'BookController@update');
    Route::delete('book/delete/{id}', 'BookController@destroy');

    Route::post('writer/create', 'WriterController@store');
    Route::put('writer/update/{id}', 'WriterController@update');
    Route::delete('writer/delete/{id}', 'WriterController@destroy');
});

Route::get('writer/list', 'WriterController@index');
