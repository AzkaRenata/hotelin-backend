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

Route::get('/booking/done', 'App\Http\Controllers\BookingController@showDoneBookings');
Route::get('/booking/ongoing', 'App\Http\Controllers\BookingController@showOngoingBookings');
Route::get('/booking/canceled', 'App\Http\Controllers\BookingController@showCanceledBookings');
Route::post('/booking', 'App\Http\Controllers\BookingController@create');

Route::get('/booking/done', 'App\Http\Controllers\RoomController@showRooms');
