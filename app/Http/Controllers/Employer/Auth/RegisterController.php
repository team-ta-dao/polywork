<?php

namespace App\Http\Controllers\Employer\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use JWTFactory;
use JWTAuth;
use JWTAuthException;
use Illuminate\Support\Facades\DB;
use Session;
use App\Employer;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        Auth::shouldUse('employer');
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'employer_fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:employer'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ],
        [
			'employer_fullname.required' => 'Họ và tên là trường bắt buộc',
			'employer_fullname.max' => 'Họ và tên không quá 255 ký tự',
			'email.required' => 'Email là trường bắt buộc',
			'email.email' => 'Email không đúng định dạng',
			'email.max' => 'Email không quá 255 ký tự',
			'email.unique' => 'Email đã tồn tại',
			'password.required' => 'Mật khẩu là trường bắt buộc',
			'password.min' => 'Mật khẩu phải chứa ít nhất 6 ký tự',
			'password.confirmed' => 'Xác nhận mật khẩu không đúng',
		]
    );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Employer
     */
    public function postRegister(Request $request) {
        // Kiểm tra dữ liệu vào
        $allRequest  = $request->all();	
        $validator = $this->validator($allRequest);
     
        if ($validator->fails()) {
            // Dữ liệu vào không thỏa điều kiện sẽ thông báo lỗi
            return response()->json($validator->errors());
        } else {   
            // Dữ liệu vào hợp lệ sẽ thực hiện tạo người dùng dưới csdl
            $employer = new Employer();
            $employer->employer_fullname = $request->employer_fullname;
            $employer->email = $request->email;
            $employer->password = bcrypt($request->password);
            if($employer->save()) {
                // Insert thành công sẽ hiển thị thông báo
                return response()->json([
                    'status'=> 200,
                    'message'=> 'Tạo tài khoản thành công',
                    'data'=>$employer
                ]);
                } else {
                    return response()->json([
                        'status'=> 401,
                        'message'=> 'Tạo tài khoản thất bại',
                    ]);
                }
        }
    }
}
