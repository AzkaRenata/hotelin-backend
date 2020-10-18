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
  
    public function showOngoingBookings(){
        return booking::where('booking_status', '=', 1);
    }

    public function showDoneBookings(){
        // $allBookings = booking::paginate(5);
        return booking::where('booking_status', '=', 2)->paginate(15);
    }

    public function showCanceledBookings(){
        return booking::where('booking_status', '=', 3);
    }
}
