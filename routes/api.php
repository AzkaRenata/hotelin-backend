<?php

use App\Http\Controllers\HotelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
Route::get('/booking/detail/{id}','App\Http\Controllers\RoomController@findBookingType');

Route::get('/room', 'App\Http\Controllers\RoomController@index');
Route::post('/room', 'App\Http\Controllers\RoomController@create');
Route::put('/room/update/{id}', 'App\Http\Controllers\RoomController@update');
Route::delete('/room/delete/{id}', 'App\Http\Controllers\RoomController@delete');
Route::get('/room/detail/{id}', 'App\Http\Controllers\RoomController@findRoomType');
Route::get('/room/list/{id}', 'App\Http\Controllers\RoomController@showRooms');

Route::get('/hotel', 'App\Http\Controllers\HotelController@index');
Route::post('/hotel', 'App\Http\Controllers\HotelController@create');
Route::put('/hotel/update/{id}', 'App\Http\Controllers\HotelController@update');
Route::delete('/hotel/delete/{id}', 'App\Http\Controllers\HotelController@delete');
Route::get('/hotel/detail/{id}','App\Http\Controllers\RoomController@findHotelType');

Route::post('/user/register', [UserController::class, 'register']);
Route::post('/user/login', [UserController::class, 'login']);
Route::middleware('jwt.verify')->group(function () {     
	Route::get('user/', [UserController::class, 'index']);
    Route::post('/user/update-basic/{id}', [UserController::class, 'updateBasic']);
    Route::post('/user/update-picture/{id}', [UserController::class, 'updatePicture']);
    Route::post('/user/update-password/{id}', [UserController::class, 'updatePasswrod']);
    Route::delete('/user/delete/{id}', [UserController::class, 'delete']);
});