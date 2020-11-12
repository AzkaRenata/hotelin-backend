<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\room;
use App\Models\hotel;
use App\Models\booking;
use App\Models\room_facility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    public function index(){
        return room::all();
    }
  
    public function showRooms($hotel_id){
        return booking::where('hotel_id', '=', $hotel_id);
    }

    public function form(){
        $hotel = hotel::all();

        return $hotel;
    }
  
    public function findRoomType($id){
        $room = room::select('*')->where('id', $id)->first(); 
        $facility = room_facility::select('*')->where('room_id', $room->id)->get();
        
        echo $room;
        echo $room->id;
        echo $facility;
    }

    public function create(request $request){
        $room = new room;
        $user = Auth::user();
        
        $checkHotel = hotel::firstOrNew([
            'user_id' => $user->id
        ]);

        if($user->user_level == 1 && $checkHotel->exists){
            $hotel = hotel::where('user_id', '=', $user->id)->first();

            $room->hotel_id = $hotel->id;
            $room->room_type = $request->room_type;
            $room->bed_type = $request->bed_type;
            $room->room_price = $request->room_price;
            $room->guest_capacity = $request->guest_capacity;
            if(!empty($request->file('room_picture'))) {

                $validator = Validator::make($request->all(), [
                    'room_picture' => 'image|mimes:jpeg,png,jpg|max:2048',
                ]);

                if($validator->fails()){
                    return response()->json($validator->errors()->toJson(), 400);
                }

                $file = $request->file('room_picture');
                $upload_dest = 'room_picture';
                $extension = $file->extension();
                $path = $file->store($upload_dest);
                $room->room_picture = $path;

            }
            $room->save();

            return $room;
        }else{
            return "Akses Ditolak";
        }
    }

    public function uploadPicture(Request $request, $id){
        $user = Auth::user();
        $room = room::find($id);
        if(!empty($request->file('room_picture'))) {

            $validator = Validator::make($request->all(), [
                'room_picture' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);

            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }
            unlink('storage/'.$room->room_picture);
            if($user->id == $room->hotel->user_id && $user->user_level == 1){
                $file = $request->file('room_picture');
                $upload_dest = 'room_picture';
                $extension = $file->extension();
                $path = $file->store($upload_dest);
                $room->room_picture = $path;

            }
            $room->save();
        }
        
    }

    public function update(Request $request, $id){
        $room = room::find($id);
        $user = Auth::user();

        if($user->user_level == 1 && $user->id == $room->hotel->user_id){
            $room->hotel_id = $request->hotel_id;
            $room->room_type = $request->room_type;
            $room->room_price = $request->room_price;
            $room->guest_capacity = $request->guest_capacity;

            if(!empty($request->file('room_picture'))) {
                $validator = Validator::make($request->all(), [
                    'room_picture' => 'image|mimes:jpeg,png,jpg|max:2048',
                ]);

                if($validator->fails()){
                    return response()->json($validator->errors()->toJson(), 400);
                }
                unlink('storage/'.$room->room_picture);
                $file = $request->file('room_picture');
                $upload_dest = 'room_picture';
                $extension = $file->extension();
                $path = $file->store($upload_dest);
                $room->room_picture = $path;

            }
            $room->save();

            return $room;
        }else{
            return "Akses Ditolak";
        }
    }

    public function delete($id){
        $room = room::find($id);
        $user = Auth::user();

        if($user->id == $room->hotel->user_id && $user->user_level == 1){
            unlink('storage/'.$room->room_picture);
            $room->delete();

            return "Data berhasil dihapus";
        }else{
            return "Akses Ditolak";
        }
    }
}
