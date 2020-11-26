<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomFacilityController;
use App\Http\Controllers\FacilityCategoryController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReviewController;


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
Route::post('/user/registerCustomer', [UserController::class, 'registerCustomer']);
Route::post('/user/login', [UserController::class, 'login']);

Route::middleware('jwt.verify')->group(function () {     
	Route::get('user', [UserController::class, 'index']);
    Route::post('/user/update', [UserController::class, 'update']);
    Route::post('/user/update-picture', [UserController::class, 'updatePicture']);
    Route::post('/user/update-password', [UserController::class, 'updatePassword']);
    Route::delete('/user/delete', [UserController::class, 'delete']);
    Route::get('/user/logout', [UserController::class, 'logout']);

    Route::get('/hotel', [HotelController::class,'index']);
    Route::post('/hotel/create', [HotelController::class,'create']);
    Route::post('/hotel/update', [HotelController::class,'update']);
    Route::delete('/hotel/delete/{id}', [HotelController::class,'delete']);
    Route::get('/hotel/detail/{id}', [HotelController::class,'findHotelType']);
    Route::get('/hotel/profile', [HotelController::class,'getHotelProfile']);
    Route::put('/hotel/upload-picture/{id}', [HotelController::class,'uploadPicture']);
    Route::get('/hotel/facility', [HotelController::class,'getHotelFacilities']);
    Route::get('/hotel/price', [HotelController::class,'getHotelPrice']);
    
    Route::post('/booking/create', [BookingController::class,'create']);
    Route::post('/booking/update/{id}', [BookingController::class,'update']);
    Route::post('/booking/change-status/{id}/{status}', [BookingController::class,'updateBookingStatus']);
    Route::delete('/booking/delete/{id}', [BookingController::class,'delete']);
    Route::get('/booking/list/{status_id?}', [BookingController::class,'showBookings']);
    Route::get('/booking/show/{id}', [BookingController::class,'showBookingById']);
    Route::get('/booking/detail/{id}', [BookingController::class,'findBookingType']);

    Route::get('/room', [RoomController::class,'index']);
    Route::get('/room/list/{id}', [RoomController::class, 'getRoomById']);
    Route::post('/room/create', [RoomController::class,'create']);
    Route::post('/room/update/{id}', [RoomController::class,'update']);
    Route::put('/room/upload-picture/{id}', [RoomController::class,'uploadPicture']);
    Route::delete('/room/delete/{id}', [RoomController::class,'delete']);
    Route::get('/room/detail/{id}', [RoomController::class,'findRoomType']);
    Route::get('/room/hotel/{id}', [RoomController::class,'showRoomByHotel']);
    Route::get('/room/list', [RoomController::class,'getHotelRoom']);

    Route::get('/facility-category', [FacilityCategoryController::class, 'index']);
    Route::post('/facility-category/create', [FacilityCategoryController::class, 'create']);
    Route::put('/facility-category/update/{id}', [FacilityCategoryController::class, 'update']);
    Route::delete('/facility-category/delete/{id}', [FacilityCategoryController::class, 'delete']);

    Route::get('/room-facility', [RoomFacilityController::class, 'index']);
    Route::post('/room-facility/{room}/{facility}', [RoomFacilityController::class, 'create']);
    Route::put('/room-facility/update/{id}', [RoomFacilityController::class, 'update']);
    Route::delete('/room-facility/delete/{id}', [RoomFacilityController::class, 'delete']);

    Route::get('/review/hotel', [ReviewController::class, 'getHotelReview']);
});
