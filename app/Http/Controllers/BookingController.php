<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\booking;
use App\Models\room;
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

    public function updateBookingStatus($id, $status){
        $user = Auth::user();
        $booking = booking::find($id);
        if($status >= 1 && $status <= 3){
            if($booking->user_id == $user->id){
                $booking->booking_status = $status;
                $booking->save();
                return response()->json([
                    'success' => true,
                    'message' => "Berhasil update"
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => "Akses Ditolak"
                ]);
            }
        } else {
            return response()->json([
                    'success' => false,
                    'message' => "Salah Input Status"
                ]);
        }
        
    }

    public function update(Request $request, $id){
        $booking = booking::find($id);
        $user = Auth::user();
        
        if($booking->user_id == $user->id){
            $booking->room_id = $request->room_id;
            $booking->check_in = $request->check_in;
            $booking->check_out = $request->check_out;
            $booking->save();
            return response()->json([
                'success' => true,
                'message' => "Berhasil update"
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => "Akses Ditolak"
            ]);
        }
        
    }

    public function delete($id){
        $user = Auth::user();
        if($user->user_level == 1){
            $hotel_id = $user->hotel->id;
            $room = room::select('id')->where('hotel_id',$hotel_id)->get();
            $booking = booking::find($id);

            foreach ($room as $room_id) {
                if($booking->room_id == $room_id->id){
                    $booking->delete();
                    return response()->json([
                        'success' => true,
                        'message' => "Berhasil delete"
                    ]);
                }
            }
           
            return response()->json([
                        'success' => false,
                        'message' => "Gagal delete"
                    ]);
        } else if($user->user_level == 2){
            $booking = booking::find($id);
            if($booking->user_id == $user->id){
                $booking->delete();
                return response()->json([
                'success' => true,
                'message' => "Berhasil delete"
            ]);
            } else {
                return response()->json([
                'success' => false,
                'message' => "Akses Ditolak"
            ]);
            }
            
        }
        
    }

    public function findBookingType($id){
        return booking::select('user_id','room_id')->where('id', $id)->get();
    }
  
    public function showBookings($status_id=null){
        $user = Auth::user();
        //return booking::where('booking_status',$status_id);
        if($status_id == null || ($status_id >=1 && $status_id <=3)){
             if($user->user_level == 1){
                $hotel_id = $user->hotel->id;
                $booking = DB::table('hotel')
                ->join('room','hotel.id','=','room.hotel_id')
                ->join('booking','room.id','=','booking.room_id')
                ->join('users','users.id','=','booking.user_id')
                ->where('hotel.id',$hotel_id)
                ->select('booking.*','hotel.hotel_name',
                    'room.room_type','room.bed_type',
                    'room.room_price','users.name');
                if($status_id == null){
                    return $booking->get();
                } else {
                   return $booking->where('booking.booking_status',$status_id)->get();
                }

            } else if ($user->user_level == 2){
                $booking = DB::table('users')
                ->join('booking','users.id','=','booking.user_id')
                ->join('room','room.id','=','booking.room_id')
                ->join('hotel','hotel.id','=','room.hotel_id')
                ->where('users.id',$user->id);
                if($status_id == null){
                    return $booking->get();
                } else {
                   return $booking->where('booking.booking_status',$status_id)->get();
                }
            }
        } else {
             return response()->json([
                'success' => false,
                'message' => "Status ID tidak ditemuka"
                ]);
        }
           
        
        //return booking::where('booking_status', '=', 1)->paginate(15);
    }

    public function showBookingById($id){
        $booking = DB::table('booking')
                ->join('users','users.id','=','booking.user_id')
                ->join('room','room.id','=','booking.room_id')
                ->join('hotel','hotel.id','=','room.hotel_id')
                ->where('booking.id',$id)
                ->select('booking.*','users.name',
                    'hotel.hotel_name','room.room_type',
                    'room.bed_type','room.room_price')
                ->get();
        return $booking;
    }

}
