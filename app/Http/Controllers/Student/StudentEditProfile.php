<?php

namespace App\Http\Controllers\Student;

use App\CV;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


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
        if(!$request->hasFile('file')) {
            return response()->json(['upload_file_not_found'], 400);
        }
        $allowedfileExtension=['pdf','jpg','png','docx','xlsx'];
        $files = $request->file('file'); 
        $errors = [];
        foreach ($files as $file) {      
            $extension = $file->getClientOriginalExtension();
            $check = in_array($extension,$allowedfileExtension);
            if($check) {
                foreach($request->file as $mediaFiles) {
                    $media = new CV();
                    $media_ext = $mediaFiles->getClientOriginalName();
                    $media_no_ext = pathinfo($media_ext, PATHINFO_FILENAME);
                    $filePath = $file->storeAs('uploads/cv/'.Auth::user()->username.'', $media_ext, 'public');
                    $mFiles = $media_no_ext . '-' . uniqid() . '.' . $extension;
                    $media->title = $media_no_ext;
                    $media->slug = $filePath;
                    $media->student_id = Auth::user()->id;
                    $media->save();
                }
            } else {
                return response()->json(['invalid_file_format'], 422);
            }
            return response()->json(['file_uploaded'], 200);
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
    public function update(Request $request, $id)
    {
        //
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
