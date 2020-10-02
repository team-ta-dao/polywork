<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Student;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
            return response()->json($validator->errors(),401);
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
    public function UserisRessetPassword(Request $request){
        $student_id = Auth::user()->id;
        $student = Student::query()->where('id',$student_id)->first();
        if(Hash::check($request->password, $student->password)){
            if($request->password_new  == $request->password_confirm){
                $updatePasswordStudent = Student::find($student_id);
                $updatePasswordStudent->password = Hash::make($request->password_new);
                $updatePasswordStudent->save();
                return response()->json(['success' => 'Thay đổi mật khẩu thành công'], 200);
            }else{
                return response()->json(['error' => 'Mật khẩu không giống nhau'], 401);
            }
        }else{
            return response()->json(['error' => 'Mật khẩu của bạn không đúng'], 401);
        }
    }
}
