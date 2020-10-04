<?php

namespace App\Http\Controllers\Employer;

use Validator;
use App\Company;
use App\Employer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            $company = new Company;
            $output = $company->getDetail(Auth::user()->id);
            return response()->json(['status'=>true,'response'=>$output,'message'=>'check-sucsecc'],200);
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
        if(Auth::user()->email === $request->email){
            $validator = Validator::make($request->all(), [
                'email' => 'nullable|string|email|max:100',
                'slogan'=> 'nullable|string|max:255',
                'name' => 'nullable|string|max:100',
                'address' => 'nullable|string|max:100',
                'desc' => 'nullable|string|max:500',
            ]);
        }
        $validator = Validator::make($request->all(), [
            'email' => 'nullable|string|email|unique:company|max:100',
            'slogan'=> 'nullable|string|max:255',
            'name' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:100',
            'desc' => 'nullable|string|max:500',
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
                $images = 'uploads/company/'.str_slug($request->company_name,'-').'/'.$file_ext;
                $path = str_replace('\\','/',public_path());
                if(!file_exists($path.$images)){
                $filePath = $files->storeAs('uploads/company/'.str_slug($request->company_name,'-').'',$file_ext, 'public');
                Image::make($files)->resize(300, 300);
                $updateProfile->avatar = $file_ext;
                }
            } else {
                return response()->json(['invalid_file_format'], 422);
            }
        }
        $this->updateEmployer($request);
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
    public function updateEmployer(Request $request){
        if($request->fullname_employer){
            $validatora = Validator::make($request->all(), [
                'email_employer' => 'nullable|string|email|max:50',
                'fullname_employer' => 'nullable|string|max:100',
                'phone_num_employer' => 'nullable|string|max:11',
            ]);
            if ($validatora->fails()) {
                return response()->json($validator->errors(),401);
            }
            if($request->hasFile('avatar_employer')){
                $avatar_employer = $request->file('avatar_employer');
                $allowedfileExtension=['jpeg','jpg','png'];
                $extension_employer = $avatar_employer->getClientOriginalExtension();
                $check_employer = in_array($extension_employer,$allowedfileExtension);
                $file_ext_employer = "";
                if($check_employer){
                    $file_ext_employer = $avatar_employer->getClientOriginalName();
                    $images_ext_employer = 'uploads/company/'.str_slug($request->company_name,'-').'/'.$file_ext_employer;
                    $path_avatar = str_replace('\\','/',public_path());
                    if(!file_exists($path_avatar.$images_ext_employer)){
                    $filePath = $avatar_employer->storeAs('uploads/company/'.str_slug($request->company_name,'-').'/'.str_slug($request->fullname,'-').'',$file_ext_employer, 'public');
                    Image::make($avatar_employer)->resize(300, 300);
                    }
                }else{
                    return response()->json(['invalid_file_format'], 422);
                }
                $employer = Employer::updateOrCreate([
                    'id' => $request->employer_id,
                    'company_id' =>  Auth::user()->id
                ],[
                    'fullname'=>$request->fullname_employer,
                    'email' =>$request->email_employer,
                    'phong_num' =>$request->phone_num_employer,
                    'avatar' =>$file_ext_employer
                ]);
            }
        }
    }
}
