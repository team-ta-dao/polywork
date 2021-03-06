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
use App\Company;
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:employer'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ],
        [
			'name.required' => 'Họ và tên là trường bắt buộc',
			'name.max' => 'Họ và tên không quá 255 ký tự',
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
     * @return \App\Company
     */
    public function postRegister(Request $request) {
        // Kiểm tra dữ liệu vào
        $allRequest  = $request->all();	
        $validator = $this->validator($allRequest);
     
        if ($validator->fails()) {
            // Dữ liệu vào không thỏa điều kiện sẽ thông báo lỗi
            return response()->json($validator->errors(),401);
        } else {   
            // Dữ liệu vào hợp lệ sẽ thực hiện tạo người dùng dưới csdl
            $company = new Company();
            $company->name = $request->name;
            $company->email = $request->email;
            $company->password = bcrypt($request->password);
            $company->as_id = '4';
            if($company->save()) {
                // Insert thành công sẽ hiển thị thông báo
                return response()->json([
                    'status'=> 200,
                    'message'=> 'Tạo tài khoản thành công bạn vui lòng chờ ít phút',
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
    public function adminIsRegisterEmployer(Request $request){
          // Kiểm tra dữ liệu vào
          $allRequest  = $request->all();	
          $validator = $this->validator($allRequest);
       
          if ($validator->fails()) {
              // Dữ liệu vào không thỏa điều kiện sẽ thông báo lỗi
              return redirect('admin\register')->withErrors($validator)->withInput();
          } else {   
              // Dữ liệu vào hợp lệ sẽ thực hiện tạo người dùng dưới csdl
              $company = new Company();
              $company->name = $request->name;
              $company->email = $request->email;
              $company->password = bcrypt($request->password);
              $company->as_id = '1';
              if($admin->save()) {
                  // Insert thành công sẽ hiển thị thông báo
                  Session::flash('success', 'Đăng ký thành viên thành công!');
                  return redirect('/company');
                  } else {
                  // Insert thất bại sẽ hiển thị thông báo lỗi
                  Session::flash('error', 'Đăng ký thành viên thất bại!');
                  return redirect('/company');
                  }
          }
    }
}
