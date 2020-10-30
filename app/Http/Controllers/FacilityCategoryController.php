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

        $facilityCategory->facility_name = $facilityCategory->facility_name;
        $facilityCategory->facility_icon = $facilityCategory->facility_icon;
        $facilityCategory->save();

        return "Data berhasil disimpan";
    }

    public function update(request $request, $id){
        $facilityCategory = facility_category::find($id);
        
        $facilityCategory->facility_name = $facilityCategory->facility_name;
        $facilityCategory->facility_icon = $facilityCategory->facility_icon;
        $facilityCategory->save();

        return "Data berhasil diubah";
    }

    public function delete($id){
        $facilityCategory = facility_category::find($id);
        $facilityCategory->delete();

        return "Data berhasil dihapus";
    }
}
