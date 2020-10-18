<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\hotel;

class HotelController extends Controller
{
    public function findHotelType($id){
        return hotel::select('hotel_name')->where('id', $id)->get();
    }
}
