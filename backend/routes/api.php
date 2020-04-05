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
Route::post('login', 'AuthController@login');

Route::group(['middleware' => ['auth:api']], function() {
    Route::post('logout'	               , 'AuthController@logout');
    Route::post('me'		               , 'AuthController@me');
	Route::post('refresh'				   , 'AuthController@refresh');
	Route::resource('users' 			   , 'UserController');
	Route::post('users/multipleDelete' 	   , 'UserController@multipleDelete');
});