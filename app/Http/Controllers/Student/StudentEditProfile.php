<?php

namespace App\Http\Controllers\Student;

use App\CV;
use Validator;
use App\Student;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;


class StudentEditProfile extends Controller
{
    public function __construct()
    {
        Auth::shouldUse('web');
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
            $student = new Student;
            $output = $student->getDetail(Auth::user()->id);
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
        //
        if(Auth::user()->email === $request->email){
            $validator = Validator::make($request->all(), [
                'email' => 'nullable|string|email|max:50',
                'bio'=> 'nullable|string|max:255',
                'fullname' => 'nullable|string|max:100',
                'address' => 'nullable|string|max:100',
                'phone_num' => 'nullable|string|max:12',
            ]);
        }
        $validator = Validator::make($request->all(), [
            'email' => 'nullable|string|unique|email|max:50',
            'bio'=> 'nullable|string|max:255',
            'fullname' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:100',
            'phone_num' => 'nullable|string|max:12',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(),401);
        }
        $updateProfile = Student::find(Auth::user()->id);
        $updateProfile->fullname = $request->fullname;
        $updateProfile->email = $request->email;
        $updateProfile->bio = $request->bio;
        $updateProfile->address = $request->address;
        $updateProfile->phone_num = $request->phone_num;
        if($request->hasFile('file')) {
            $allowedfileExtension=['pdf','jpg','png','docx','xlsx'];
            $files = $request->file('file'); 
            $errors = [];
            foreach ($files as $file) {      
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension,$allowedfileExtension);
                if($check) {
                    foreach($request->file as $mediaFiles) {
                        $file = new CV();
                        $file_ext = $mediaFiles->getClientOriginalName();
                        $file_no_ext = pathinfo($file_ext, PATHINFO_FILENAME);
                        $filePath = $mediaFiles->storeAs('uploads/cv/'.Auth::user()->student_code.'', $file_ext, 'public');
                        $mFiles = $file_no_ext . '-' . uniqid() . '.' . $extension;
                        $file->title = $file_no_ext;
                        $file->slug = $filePath;
                        $file->student_id = Auth::user()->id;
                        $file->save();
                    }
                } else {
                    return response()->json(['invalid_file_format'], 422);
                }
                return response()->json(['file_uploaded'], 200);
            }
        }
        if($request->hasFile('avatar')) {
            $allowedfileExtension=['jpeg','jpg','png'];
            $files = $request->file('avatar'); 
            $extension = $files->getClientOriginalExtension();
            $check = in_array($extension,$allowedfileExtension);
            if($check) {
                $file_ext = $files->getClientOriginalName();
                $filePath = $files->storeAs('uploads/company/'.str_slug($request->company_name,'-').'',$file_ext, 'public');
                Image::make($files)->resize(300, 300);
                $updateProfile->avatar = $file_ext;
            } else {
                return response()->json(['invalid_file_format'], 422);
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
