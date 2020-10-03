<?php

namespace App\Http\Controllers\Employer;

use Validator;
use App\Company;
use App\Employer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;


class EmployerEditProfile extends Controller
{
    public function __construct()
    {
        Auth::shouldUse('employer');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        //
        if(Auth::check()){
            return response()->json(['status'=>true,'response'=>Auth::user(),'message'=>'check-sucsecc'],200);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        if(Auth::user()->email === $request->email){
            $validator = Validator::make($request->all(), [
                'email' => 'nullable|string|email|max:50',
                'slogan'=> 'nullable|string|max:255',
                'name' => 'nullable|string|max:100',
                'address' => 'nullable|string|max:100',
                'nation_id' => 'nullable|number|max:2',
                'area_id' => 'nullable|number|max:4',
                'name' => 'nullable|string|max:12',
                'desc' => 'nullable|string|500',
            ]);
        }
        $validator = Validator::make($request->all(), [
            'email' => 'nullable|string|email|unique:company|max:50',
            'slogan'=> 'nullable|string|max:255',
            'name' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:100',
            'nation_id' => 'nullable|number|max:2',
            'area_id' => 'nullable|number|max:4',
            'name' => 'nullable|string|max:12',
            'desc' => 'nullable|string|500',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(),401);
        }
        $updateProfile = Company::find(Auth::user()->id);
        $updateProfile->nation_id = $request->nation_id;
        $updateProfile->area_id = $request->area_id;
        $updateProfile->jc_id = $request->jc_id;
        $updateProfile->name = $request->name;
        $updateProfile->slogan = $request->slogan;
        $updateProfile->address = $request->address;
        $updateProfile->desc = $request->desc;
        if($request->hasFile('avatar')) {
            $allowedfileExtension=['jpeg','jpg','png'];
            $files = $request->file('avatar'); 
            $extension = $files->getClientOriginalExtension();
            $check = in_array($extension,$allowedfileExtension);
            if($check) {
                $file_ext = $files->getClientOriginalName();
                Image::make($files)->resize(300, 300)->save( public_path('uploads/company/'.str_slug($request->company_name,'-').'/'.$filename));
                $updateProfile->avatar = $file_ext;
            } else {
                return response()->json(['invalid_file_format'], 422);
            }
        }
        if($request->fullname_employer){
            $validator = Validator::make($request->all(), [
                'email_employer' => 'nullable|string|email|max:50',
                'fullname_employer' => 'nullable|string|max:100',
                'phone_num_employer' => 'nullable|string|max:11',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors(),401);
            }
            $employer = new Employer;
            $employer->company_id = Auth::user()->id;
            $employer->fullname = $request->fullname_employer;
            $employer->email = $request->email_employer;
            $employer->phone_num = $request->phone_num_employer;
            if($request->hasFile('avatar_employer')){
                $avatar_employer = $request->file('avatar_employer');
                $allowedfileExtension=['jpeg','jpg','png'];
                $extension_employer = $avatar_employer->getClientOriginalExtension();
                $check_employer = in_array($extension_employer,$allowedfileExtension);
                if($check_employer){
                    $file_ext_employer = $avatar_employer->getClientOriginalName();
                    Image::make($avatar_employer)->resize(300, 300)->save(public_path('uploads/company/'.str_slug($request->company_name,'-').'/'.str_slug($request->fullname,'-').'/'.$filename));
                    $employer->phone_num = $file_ext_employer;
                    $employer->save();
                }else{
                    return response()->json(['invalid_file_format'], 422);
                }
            }
        }
        if($updateProfile->save()){
            return response()->json(['success' => 'success update profile'], 200);
        }else{
            return response()->json(['error' => 'no success'], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
