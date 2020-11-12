<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\hotel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class HotelController extends Controller
{
    public function index(){
        return hotel::all();
    }

    public function findHotelType($id){
        return hotel::select()->where('id', $id)->get();
    }

    public function getHotelByOwner(){
        $user = Auth::user();
        $hotel = hotel::select()->where('user_id', $user->id)->get();
        if($user->user_level == 1){
            return $hotel;
        } else {
            return "akses ditolak";
        }
    }

    public function create(Request $request){
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

            if(!empty($request->file('hotel_picture'))) {
                $validator = Validator::make($request->all(), [
                    'hotel_picture' => 'image|mimes:jpeg,png,jpg|max:2048',
                ]);

                if($validator->fails()){
                    return response()->json($validator->errors()->toJson(), 400);
                }
                $file = $request->file('hotel_picture');
                $upload_dest = 'hotel_picture';
                $extension = $file->extension();
                $path = $file->storeAs(
                    $upload_dest, $user->id.'.'.$extension
                );
                $hotel->hotel_picture = $path;

            }
            $hotel->save();

            return $hotel;
        }else{
            return "Sudah ada Hotel";
        }
    }

    public function uploadPicture(Request $request, $id){
        $user_id = Auth::user()->id;
        $hotel = hotel::find($id);
        if(!empty($request->file('room_picture'))) {

            $validator = Validator::make($request->all(), [
                'hotel_picture' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);

            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }
            
            if($user_id == $hotel->user_id){
                unlink('storage/'.$hotel->hotel_picture);
                $file = $request->file('hotel_picture');
                $upload_dest = 'hotel_picture';
                $extension = $file->extension();
                $path = $file->store($upload_dest);
                $hotel->hotel_picture = $path;

            }
            $hotel->save();
        }

        return $hotel;
        
    }

    public function update(request $request, $id){
        $hotel = hotel::find($id);
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'user_picture' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        if($user->user_level == 1 && $user->id == $hotel->user_id){
            $hotel->hotel_name = $request->hotel_name;
            $hotel->hotel_location = $request->hotel_location;
            $hotel->hotel_desc = $request->hotel_desc;
            $hotel->user_id = $user->id;

            if(!empty($request->file('hotel_picture'))) {
                unlink('storage/'.$hotel->hotel_picture);
                $file = $request->file('hotel_picture');
                $upload_dest = 'hotel_picture';
                $extension = $file->extension();
                $path = $file->storeAs(
                    $upload_dest, $hotel->user_id.'.'.$extension
                );
                $hotel->hotel_picture = $path;

            }

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
            unlink('storage/'.$hotel->hotel_picture);
            $hotel->delete();

            return "Data berhasil dihapus";
        }else{
            return "Akses Ditolak";
        }
    }
}