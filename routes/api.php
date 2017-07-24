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


//Route::get('login', [ 'as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);

// get the TOKEN

/** /token */

//Route::post('token', "TokenController");

Route::post('client/create', "ClientController@store");

Route::post('user/register', "UserController@register");
Route::post('user/token', "UserController@token");

//Route::resource('client', 'ClientController', ['only' => [
//    'store', 'update', 'destroy'
//]]);


/** /validateRequest */