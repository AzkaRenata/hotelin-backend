<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomFacilityController;
use App\Http\Controllers\FacilityCategoryController;
use App\Http\Controllers\BookingController;


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



Route::post('/user/register', [UserController::class, 'register']);
Route::post('/user/login', [UserController::class, 'login']);

Route::middleware('jwt.verify')->group(function () {     
	Route::get('user', [UserController::class, 'index']);
    Route::post('/user/update', [UserController::class, 'update']);
    Route::post('/user/update-picture', [UserController::class, 'updatePicture']);
    Route::post('/user/update-password', [UserController::class, 'updatePassword']);
    Route::delete('/user/delete', [UserController::class, 'delete']);
    Route::get('/user/logout', [UserController::class, 'logout']);

    Route::get('/hotel', [HotelController::class,'index']);
    Route::post('/hotel', [HotelController::class,'create']);
    Route::post('/hotel/update/{id}', [HotelController::class,'update']);
    Route::delete('/hotel/delete/{id}', [HotelController::class,'delete']);
    Route::get('/hotel/detail/{id}', [HotelController::class,'findHotelType']);
    Route::get('/hotel/profile', [HotelController::class,'getHotelByOwner']);
    Route::put('/hotel/upload-picture/{id}', [HotelController::class,'uploadPicture']);
    
    Route::get('/booking/done', [BookingController::class,'showDoneBookings']);
    Route::get('/booking/ongoing', [BookingController::class,'showOngoingBookings']);
    Route::get('/booking/canceled', [BookingController::class,'showCanceledBookings']);
    Route::post('/booking', [BookingController::class,'create']);
    Route::get('/booking/detail/{id}', [BookingController::class,'findBookingType']);

    Route::get('/room', [RoomController::class,'index']);
    Route::post('/room', [RoomController::class,'create']);
    Route::put('/room/update/{id}', [RoomController::class,'update']);
    Route::put('/room/upload-picture/{id}', [RoomController::class,'uploadPicture']);
    Route::delete('/room/delete/{id}', [RoomController::class,'delete']);
    Route::get('/room/detail/{id}', [RoomController::class,'findRoomType']);
    Route::get('/room/list/{id}', [RoomController::class,'showRooms']);

    Route::get('/facility-category', [FacilityCategoryController::class, 'index']);
    Route::post('/facility-category', [FacilityCategoryController::class, 'create']);
    Route::put('/facility-category/update/{id}', [FacilityCategoryController::class, 'update']);
    Route::delete('/facility-category/delete/{id}', [FacilityCategoryController::class, 'delete']);

    Route::get('/room-facility', [RoomFacilityController::class, 'index']);
    Route::post('/room-facility/{room}/{facility}', [RoomFacilityController::class, 'create']);
    Route::put('/room-facility/update/{id}', [RoomFacilityController::class, 'update']);
    Route::delete('/room-facility/delete/{id}', [RoomFacilityController::class, 'delete']);
});
