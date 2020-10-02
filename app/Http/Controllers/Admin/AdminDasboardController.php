<?php

namespace App\Http\Controllers\Admin;

use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdminDasboardController extends Controller
{
    //
    public function __contruct(){
        if(!Auth::guard('admin')->check()){
            return redirect('/login');
        }
    }
    public function index(){
        $student_get_all = Student::all();
        return redirect()->with('student_get_all');
    }
    // chart js
}
