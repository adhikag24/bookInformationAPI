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
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('register', 'JWTAuthController@register');
    Route::post('login', 'JWTAuthController@login');
    Route::post('logout', 'JWTAuthController@logout');
    Route::post('refresh', 'JWTAuthController@refresh');
    Route::get('profile', 'JWTAuthController@profile');

});


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('register', 'JWTAuthController@register');
    Route::post('login', 'JWTAuthController@login');
    Route::post('logout', 'JWTAuthController@logout');
    Route::post('refresh', 'JWTAuthController@refresh');
    Route::get('profile', 'JWTAuthController@profile');

});

Route::group([
    'prefix' => 'book'

], function ($router) {
    Route::get('list', 'BookController@index');
    Route::get('detail/{id}', 'BookController@show');
    Route::post('filter/{whatToFilter}', 'BookController@filter');
});


Route::group([
    'middleware' => 'api',
    'prefix' => 'admin'
], function ($router) {
    // Route::post('book/create_book', 'BookController@store');
    Route::get('detail/{id}', 'BookController@show');
    Route::post('filter/{whatToFilter}', 'BookController@filter');
});
Route::post('admin/book/create', 'BookController@store');



// Route::get('book/list', 'BookController@index');
// Route::get('book/detail/{id}', 'BookController@show');
// Route::post('book/filter/{whatToFilter}', 'BookController@filter');

Route::get('writer/list', 'WriterController@index');
