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

Route::post('login', 'Api\Auth\LoginController@login')->name('api.jwt.login');
Route::post('register', 'Api\Auth\RegisterController@register')->name('api.jwt.register');

Route::get('unauthorized', function(){
    return response()->json([
        'status' => 'error',
        'message' => 'Sin autorización'
    ], 401);
})->name('api.jwt.unauthorized');

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('user', 'Api\Auth\LoginController@user')->name('api.jwt.user');
    Route::get('refresh', 'Api\Auth\LoginController@refresh')->name('api.jwt.refresh');
    Route::get('logout','Api\Auth\LoginController@logout')->name('api.jwt.logout');
});
