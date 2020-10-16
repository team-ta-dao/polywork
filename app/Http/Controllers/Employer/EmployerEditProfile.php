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
use Illuminate\Validation\Rule;


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
            $output = Company::with('EmployerIsCompany')->with('CategoryCompany')->where('id','=',Auth::user()->id)->get();
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
        $validator = Validator::make($request->all(), [
            'email' => 'nullable|string|email|max:100|'.Rule::unique('company','email')->ignore(Auth::user()->id).'',
            'slogan'=> 'nullable|string|max:255',
            'name' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:100',
            'desc' => 'nullable|string|max:500',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(),401);
        }
        $updateProfile = Company::find(Auth::user()->id);
        $date = date_create($request->founding);
        $updateProfile->founding = date_format($date, 'Y/m/d');
        if ($request->nation_id != null) {
            $getIdArea = DB::table("nation")->where('slug', '=', $request->nation_id)->first();
            $updateProfile->nation_id = $getIdArea->id;
        }
        if (is_string($request->jc_id)) {
            $getIdMarjor = DB::table("job_category")->where('slug', '=', $request->jc_id)->first();
            if ($getIdMarjor) {
                $updateProfile->jc_id = $getIdMarjor->id;
            }
        }
        if ($request->area_id != null) {
            $getIdArea = DB::table("area")->where('slug', '=', $request->area_id)->first();
            $updateProfile->area_id = $getIdArea->id;
        }
        if ($request->district_id != null) {
            $getIdDistrict = DB::table("district")->where('slug', '=', $request->district_id)->first();
            $updateProfile->district_id = $getIdDistrict->id;
        }
        $updateProfile->name = $request->name;
        $updateProfile->email = $request->email;
        $updateProfile->slogan = $request->slogan;
        $updateProfile->address = $request->address;
        $updateProfile->desc = $request->desc;
        if($request->hasFile('avatars')) {
            $allowedfileExtension=['jpeg','jpg','png'];
            $files = $request->file('avatars'); 
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
    public function upDateCorveImage(Request $request){
        if($request->hasFile('cover_img')) {
            $updateProfile = Company::find(Auth::user()->id);
            $allowedfileExtension=['jpeg','jpg','png'];
            $files_cover_img = $request->file('cover_img'); 
            $extension = $files_cover_img->getClientOriginalExtension();
            $check = in_array($extension,$allowedfileExtension);
            if($check) {
                $file_ext_cover_img = $files_cover_img->getClientOriginalName();
                $images = 'uploads/company/'.str_slug($request->company_name,'-').'/'.$file_ext_cover_img;
                $path = str_replace('\\','/',public_path());
                if(!file_exists($path.$images)){
                $filePath = $files_cover_img->storeAs('uploads/company/'.str_slug($request->company_name,'-').'',$file_ext_cover_img, 'public');
                Image::make($files_cover_img)->resize(300, 300);
                $updateProfile->cover_img = $file_ext_cover_img;
                if($updateProfile->save()){
                    return response()->json(['success' => 'success update profile'], 200);
                }else{
                    return response()->json(['error' => 'no success'], 200);
                }
                }
            } else {
                return response()->json(['invalid_file_format'], 422);
            }
        }
    }
    public function updateEmployer(Request $request){
        if($request->fullname_employer){
            $validatora = Validator::make($request->all(), [
                'email_employer' => 'nullable|string|email|max:50|unique:company,email',
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