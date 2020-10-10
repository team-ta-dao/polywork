<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Information extends Controller
{
    
    public function sendAllArea(){
        $output = DB::table("area")->get();
        return response()->json(['response'=>$output]);
    }
    public function sendAllDistrict(Request $request){
        $output = DB::table("district")->where('area_id','=',$request->id)->get();
        return response()->json(['response'=>$output]);
    }
    public function sendAllNation(){
        $output = DB::table("nation")->get();
        return response()->json(['response'=>$output]);
    }
    public function getAllTag(){
        $output=  Skill_tag::all();
        return response()->json(['response'=>$output]);
    }
}
