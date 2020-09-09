<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Student;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use JWTFactory;
use JWTAuth;
use JWTAuthException;
use Validator;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Contracts\JWTSubject as JWTSubject;
class StudentLogin extends Controller
{
    public function __construct()
    {
        Auth::shouldUse('web');
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'username' => 'required|string|max:20',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        // $student= Student::where('id','=',$request->mssv)->first();
        $credentials = $request->only('username', 'password');
        $token = null;
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Please check username or password'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json(compact('token'));
    }
    public function getAuthenticatedUser()
    {
    if(Auth::check()){
        return response()->json(['status'=>true,'response'=>Auth::user(),'message'=>'check-sucsecc'],200);
    }
    }
}
