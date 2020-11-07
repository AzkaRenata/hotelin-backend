<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\hotel;
use Illuminate\Support\Facades\Auth;

class HotelController extends Controller
{
    public function index(){
        return hotel::all();
    }

    public function findHotelType($id){
        return hotel::select()->where('id', $id)->get();
    }

    public function create(request $request){
        $hotel = new hotel();
        $user = Auth::user();
        
        $checkUser = hotel::firstOrNew([
            'user_id' => $user->id
        ]);
        
        if($user->user_level == 1 && !$checkUser->exists){
            $hotel->hotel_name = $request->hotel_name;
            $hotel->hotel_location = $request->hotel_location;
            $hotel->hotel_desc = $request->hotel_desc;
            $hotel->user_id = $user->id;
            $hotel->save();

            return $hotel;
        }else{
            return "Sudah ada Hotel";
        }
    }

    public function update(request $request, $id){
        $hotel = hotel::find($id);
        $user = Auth::user();

        if($user->user_level == 1 && $user->id == $hotel->user_id){
            $hotel->hotel_name = $request->hotel_name;
            $hotel->hotel_location = $request->hotel_location;
            $hotel->hotel_desc = $request->hotel_desc;
            $hotel->user_id = $request->user_id;
            $hotel->save();

            return $hotel;
        }else{
            return "Akses Ditolak";
        }
    }

    public function delete($id){
        $hotel = hotel::find($id);
        $user = Auth::user();

        if($user->user_level == 1 && $user->id == $hotel->user_id){
            $hotel->delete();

            return "Data berhasil dihapus";
        }else{
            return "Akses Ditolak";
        }
    }
}