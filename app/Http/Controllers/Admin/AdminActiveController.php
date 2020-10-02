<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminActiveController extends Controller
{
    public function __contruct(){
        if(!Auth::guard('admin')->check()){
            return redirect('/login');
        }
    }
    public function getViewActive(){
        $company = Company::all();
        return redirect('/company')->with('company');
    }
    public function AdminIsActiveCompany(Request $request){
        if($request->active){
            if($request->active == '4'||$request->active == '3'){
                Company::updateOrCreate(
                    ['id'=>$request->company_id],
                    ['as_id'=>'1']
                );
                return response()->json(['success'=>'Tài khoản doanh nghiệp đã được kích hoạt']);
            }elseif($request->active == '1'){
                Company::updateOrCreate(
                    ['id'=>$request->company_id],
                    ['as_id'=>'3']
                );
                return response()->json(['success'=>'Tài khoản doanh nghiệp bị khóa kích hoạt']);
            }
        }        
    }
}
