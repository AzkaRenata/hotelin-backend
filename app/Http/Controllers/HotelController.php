<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\hotel;

class HotelController extends Controller
{
    public function index(){
        return hotel::all();
    }
  
    public function findHotelType($id){
        return hotel::select('hotel_name')->where('id', $id)->get();
    }

    public function form(){
        
    }
    public function create(request $request){
        $hotel = new hotel();
        $hotel->hotel_name = $request->input('hotel_name');
        $hotel->hotel_location = $request->input('hotel_location');
        $hotel->hotel_desc = $request->input('hotel_desc');
        $hotel->save();

        return "Data berhasil disimpan";
    }

    public function update(request $request, $id){
        $hotel = hotel::find($id);
        
        $hotel->hotel_name = $request->input('hotel_name');
        $hotel->hotel_location = $request->input('hotel_location');
        $hotel->hotel_desc = $request->input('hotel_desc');
        $hotel->save();

        return "Data berhasil diubah";
    }

    public function delete($id){
        $hotel = hotel::find($id);
        $hotel->delete();

        return "Data berhasil dihapus";
    }
}
