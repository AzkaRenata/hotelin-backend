<?php

use App\Http\Controllers\HotelController;
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

Route::get('/room', 'App\Http\Controllers\RoomController@index');
Route::post('/room', 'App\Http\Controllers\RoomController@create');
Route::put('/room/update/{id}', 'App\Http\Controllers\RoomController@update');
Route::delete('/room/delete/{id}', 'App\Http\Controllers\RoomController@delete');
Route::get('/room/detail/{id}', 'App\Http\Controllers\RoomController@findRoomType');

Route::get('/hotel', 'App\Http\Controllers\HotelController@index');
Route::post('/hotel', 'App\Http\Controllers\HotelController@create');
Route::put('/hotel/update/{id}', 'App\Http\Controllers\HotelController@update');
Route::delete('/hotel/delete/{id}', 'App\Http\Controllers\HotelController@delete');
Route::get('/hotel/detail/{id}','App\Http\Controllers\RoomController@findHotelType');

Route::get('/booking/detail/{id}','App\Http\Controllers\RoomController@findBookingType');