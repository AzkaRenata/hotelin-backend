<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\facility_category;

class FacilityCategoryController extends Controller
{
    public function index(){
        return facility_category::all();
    }

    public function create(request $request){
        $facilityCategory = new facility_category();

        $facilityCategory->facility_name = $request->facility_name;
        $facilityCategory->facility_icon = $request->facility_icon;
        $facilityCategory->save();

        return $facilityCategory;
    }

    public function update(request $request, $id){
        $facilityCategory = facility_category::find($id);
        
        $facilityCategory->facility_name = $request->facility_name;
        $facilityCategory->facility_icon = $request->facility_icon;
        $facilityCategory->save();

        return $facilityCategory;
    }

    public function delete($id){
        $facilityCategory = facility_category::find($id);
        $facilityCategory->delete();

        return "Data Berhasil Dihapus";
    }
}
