<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\booking;

class BookingController extends Controller
{
    public function findBookingType($id){
        return booking::select('user_id','room_id')->where('id', $id)->get();
    }
}
