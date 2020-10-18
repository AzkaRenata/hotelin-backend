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

Route::get('/room','App\Http\Controllers\RoomController@index');
Route::get('/room/{id}','App\Http\Controllers\RoomController@findRoomType');
Route::post('/room','App\Http\Controllers\RoomController@create');
Route::put('/room/{id}','App\Http\Controllers\RoomController@update');
Route::delete('/room/{id}','App\Http\Controllers\RoomController@delete');

Route::get('/hotel/{id}','App\Http\Controllers\RoomController@findHotelType');

Route::get('/booking/{id}','App\Http\Controllers\RoomController@findBookingType');