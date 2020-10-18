<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\booking;
use Illuminate\Http\Request;


class BookingController extends Controller
{
    //
    public function showOngoingBookings(){
        return booking::where('status', '=', 1);
    }

    public function showDoneBookings(){
        // $allBookings = booking::paginate(5);
        return booking::where('status', '=', 2)->paginate(15);
    }

    public function showCanceledBookings(){
        return booking::where('status', '=', 3);
    }
    
}
