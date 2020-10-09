<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Information extends Controller
{
    //
    public function sendAllArea(){
        $output = DB::table("area")->get();
        return response()->json(['response'=>$output]);
    }
}
