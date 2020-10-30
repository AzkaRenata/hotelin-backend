<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\room_facility;

class RoomFacilityController extends Controller
{
    public function index(){
        return room_facility::all();
    }


    public function create(request $request){
        $roomFacility = new room_facility();

        $roomFacility->room_id = $roomFacility->room_id;
        $roomFacility->facility_category_id = $roomFacility->facility_category_id;
        $roomFacility->description = $roomFacility->description;
        $roomFacility->save();

        return "Data berhasil disimpan";
    }

    public function update(request $request, $id){
        $roomFacility = room_facility::find($id);
        
        $roomFacility->room_id = $roomFacility->room_id;
        $roomFacility->facility_category_id = $roomFacility->facility_category_id;
        $roomFacility->description = $roomFacility->description;
        $roomFacility->save();

        return "Data berhasil diubah";
    }

    public function delete($id){
        $roomFacility = room_facility::find($id);
        $roomFacility->delete();

        return "Data berhasil dihapus";
    }
}
