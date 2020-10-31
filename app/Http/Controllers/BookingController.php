<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\booking;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index(){
        return booking::all();
    }

    public function create(request $request){
        $booking = new booking();
        $user = Auth::user();

        $booking->user_id = $user->id;
        $booking->room_id = $request->room_id;
        $booking->booking_status = 1;
        $booking->check_in = $request->check_in;
        $booking->check_out = $request->check_out;
        $booking->booking_time = now();
        $booking->save();

        return $booking::all();
    }

    public function finishBooking(request $request, $id){
        $booking = booking::find($id);
        
        $booking->booking_status = 2;
        $booking->save();

        return $booking::all();
    }

    public function cancelBooking(request $request, $id){
        $booking = booking::find($id);
        
        $booking->booking_status = 3;
        $booking->save();

        return $booking::all();
    }

    public function update(request $request, $id){
        $booking = booking::find($id);
        $user = Auth::user();
        
        $booking->user_id = $user->id;
        $booking->room_id = $request->room_id;
        $booking->booking_status = $request->booking_status;
        $booking->check_in = $request->check_in;
        $booking->check_out = $request->check_out;
        $booking->save();

        return "Data berhasil diubah";
    }

    public function delete($id){
        $booking = booking::find($id);
        $booking->delete();

        return "Data berhasil dihapus";
    }

    public function findBookingType($id){
        return booking::select('user_id','room_id')->where('id', $id)->get();
    }
  
    public function showOngoingBookings(){
        return booking::where('booking_status', '=', 1)->paginate(15);
    }

    public function showDoneBookings(){
        // $allBookings = booking::paginate(5);
        return booking::where('booking_status', '=', 2)->paginate(15);
    }

    public function showCanceledBookings(){
        return booking::where('booking_status', '=', 3)->paginate(15);
    }
}
