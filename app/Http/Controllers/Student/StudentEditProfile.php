<?php

namespace App\Http\Controllers\Student;

use App\CV;
use Validator;
use App\Student;
use App\Skill_tag;
use App\Pet_project;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;


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
        if(Auth::check()){
            $student = Student::with('student_skill')->with('student_cv')->with('student_pet_project')->where('id', '=', Auth::user()->id)->get();
            return response()->json(['status'=>true,'response'=>$student,'message'=>'check-sucsecc'],200);
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
            'email' => 'nullable|string|max:100|email|'.Rule::unique('student','email')->ignore(Auth::user()->id).'',
            'bio'=> 'nullable|string|max:255',
            'fullname' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:100',
            'phone_num' => 'nullable|string|max:12',
            'dob' => 'date'
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
        $updateProfile->dob = $request->dob;
        if(isset($request->skill_tag)){
            foreach($request->skill_tag as $row){
               $check = Student::findOrFail(Auth::user()->id)->student_skill()->where('skill_tag_id','=',$row)->count();
                if($check == 0){
                    $student = Student::findOrFail(Auth::user()->id)->student_skill()->attach($row);
                }
            }
        }        
        if($request->hasFile('avatar')) {
            $allowedfileExtension=['jpeg','jpg','png'];
            $files = $request->file('avatar'); 
            $extension = $files->getClientOriginalExtension();
            $check = in_array($extension,$allowedfileExtension);
            if($check) {
                $file_ext = $files->getClientOriginalName();
                $images = '/storage/uploads/student/'.Auth::user()->student_code.'/avatar/'.$file_ext;
                $path = str_replace('\\','/',public_path());
                if(!file_exists($path.$images)){
                $filePath = $files->storeAs('uploads/student/'.Auth::user()->student_code.'/avatar', $file_ext, 'public');
                Image::make($files)->resize(300, 300);
                $updateProfile->avatar = $file_ext;
                }
            } else {
                return response()->json(['File Avatar không đúng định dạng'], 422);
            }
        }
        $this->multiUploadCv($request);
        $this->multiUploadPetProject($request);
        if($updateProfile->save()){
            return response()->json(['success' => 'success update profile'], 200);
        }else{
            return response()->json(['error' => 'no success'], 200);
        }
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
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::findOrFail(Auth::user()->id)->student_skill()->detach($id);
    }
    public function multiUploadCv(Request $request){
        if($request->hasFile('file')) {
            $allowedfileExtension=['pdf','jpg','png','docx','xlsx'];
            $files = $request->file('file'); 
            $errors = [];
            foreach ($files as $file) {      
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension,$allowedfileExtension);
                if($check) {
                    foreach($request->file as $mediaFiles) {
                        $file_ext = $mediaFiles->getClientOriginalName();
                        $file_no_ext = pathinfo($file_ext, PATHINFO_FILENAME);
                        $images = '/storage/uploads/student/'.Auth::user()->student_code.'/cv/'.$file_ext;
                        $path = str_replace('\\','/',public_path());
                        if(!file_exists($path.$images)){
                        $filePath = $mediaFiles->storeAs('uploads/student/'.Auth::user()->student_code.'/cv', $file_ext, 'public');
                        $employer = CV::updateOrCreate([
                            'id' => $request->cv_id,
                            'student_id' =>  Auth::user()->id
                        ],[
                            'title'=>$file_no_ext,
                            'slug' =>$filePath
                        ]);
                        }else{
                            return response()->json(['file_exist'], 422);
                        }
                    }
                } else {
                    return response()->json(['File CV không đúng định dạng'], 422);
                }
                return response()->json(['file_uploaded'], 200);
            }
        }
    }
    public function multiUploadPetProject(Request $request){
        if($request->student_project){
            // $pet_project = json_decode($request->stdent_project);
            foreach($request->student_project as $rows){
                    $allowedfileExtension=['pdf','jpg','png'];
                    $file_ext_project = '';
                    if(isset($rows['thum_project'])){
                    $extension = $rows['thum_project']->getClientOriginalExtension();
                    $check = in_array($extension,$allowedfileExtension);
                    if($check){
                        $file_ext_project = $rows['thum_project']->getClientOriginalName();
                        $file_no_ext = pathinfo($file_ext_project, PATHINFO_FILENAME);
                        $images = '/storage/uploads/student/'.Auth::user()->student_code.'/petproject/'.$file_ext_project;
                        $path = str_replace('\\','/',public_path());
                        if(!file_exists($path.$images)){
                        $filePath = $mediaFiles->storeAs('uploads/student/'.Auth::user()->student_code.'/petproject', $file_ext_project, 'public');
                    }
                    }
                    }
                    $updatePetproject = Pet_project::updateOrCreate([
                        'id'=> $rows['pet_project_id'],
                        'student_id' =>  Auth::user()->id
                    ],[
                        'name'=> $rows['project_name'],
                        'description' => $rows['project_description'],
                        'url' => $rows['project_url'],
                        'thump' => $file_ext_project
                    ]);
            }
        }
    }
}
