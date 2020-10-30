<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\booking;

class BookingController extends Controller
{
    public function index(){
        return booking::all();
    }

    public function create(request $request){
        $booking = new booking();
        $booking->user_id = $booking->user_id;
        $booking->room_id = $booking->room_id;
        $booking->booking_status = $booking->booking_status;
        $booking->check_in = $booking->check_in;
        $booking->check_out = $booking->check_out;
        $booking->booking_time = $booking->booking_time;
        $booking->save();

        return "Data berhasil disimpan";
    }

    public function update(request $request, $id){
        $booking = booking::find($id);
        
        $booking->user_id = $booking->user_id;
        $booking->room_id = $booking->room_id;
        $booking->booking_status = $booking->booking_status;
        $booking->check_in = $booking->check_in;
        $booking->check_out = $booking->check_out;
        $booking->booking_time = $booking->booking_time;
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
