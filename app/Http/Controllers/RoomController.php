<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\room;

class RoomController extends Controller{
    
    public function index(){
        return room::all();
    }

    public function findRoomType($id){
        return room::select('room_type')->where('id', $id)->get();
    }

    public function create(request $request){
        $room = new room;

        $room->hotel_id = $request->hotel_id;
        $room->room_type = $request->room_type;
        $room->room_price = $request->room_price;
        $room->guest_capacity = $request->guest_capacity;

        $room->save();
    }
    
    public function update(request $request, $id){
        $room = room::find($id);

        $room->hotel_id = $request->hotel_id;
        $room->room_type = $request->room_type;
        $room->room_price = $request->room_price;
        $room->guest_capacity = $request->guest_capacity;

        $room->push();
        $room->save();
    }

    public function delete($id){
        $room = room::find($id);
        $room->delete();
        return "delete succesfull";
    }
}
