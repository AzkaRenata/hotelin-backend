<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\room;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    public function showRooms($hotel_id){
        return booking::where('hotel_id', '=', $hotel_id);
    }
}
