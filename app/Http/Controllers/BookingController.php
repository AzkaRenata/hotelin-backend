<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\booking;

namespace App\Http\Controllers;

class BookingController extends Controller
{
    public function findBookingType($id){
        return booking::select('user_id','room_id')->where('id', $id)->get();
    }
  
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
