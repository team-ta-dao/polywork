<?php

namespace App\Http\Controllers\Student;

use App\Student;
use App\Skill_tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SuggestionStudent extends Controller
{
    public function Suggestion(Request $request){
        if(isset($request->student_skill)){
            $student = new Student;
            $mesage =  [];
            foreach($request->student_skill as $rows){
                $output = Skill_tag::with('student_info')->where('id','=',$rows['id'])->get();
                foreach($output as $row){
                    foreach($row['student_info'] as $key=>$value){
                            $mesage[] = $value;
                    }
                }
            }
            $colection = collect($mesage);
            $student = $colection->unique('id');
            return response()->json(['response'=>array_slice(json_decode($student,true), 0, 5)],200);
        }
    }
}
