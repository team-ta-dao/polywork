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
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password'=> 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $token = null;
        // $remember = $request->has('remember') ? true : false;
        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Vui lòng kiểm tra mật khẩu hoặc email của bạn'], 401);
            }
        $company = new Company();
        $company = Company::query()->where('email','=',$request->email)->first();
        if($company['as_id']==4){
            return response()->json(['error' => 'Tài khoản chưa được duyệt'], 401);
        }elseif ($company['as_id']==3) {
            return response()->json(['error' => 'Tài khoản đã bị khóa vui lòng liên hệ với nhà quản trị'], 401);
        }elseif ($company['as_id']==2) {
            return response()->json(['error' => 'Tài khoản đã bị đóng băng vui lòng liên hệ với nhà quản trị'], 401);
        }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
      return response()->json(compact('token'));
    }
    public function changePassword(Request $request)
    {
        $email = $request->email;
        $employer = Company::query()->where('email',$email)->first();
        if(empty($employer)){
            return response()->json(['error' => 'Vui Lòng kiểm tra lại Email của bạn'], 401);
        }
        $password = $request->password;
        if(Hash::check($password, $admin->password)){
            if($request->password_new  == $request->password_confirm){
                $updateEmployer = Company::find($admin->id);
                $updateEmployer->password = Hash::make($request->password_new);
                $updateEmployer->save();
                return response()->json(['success' => 'Thay đổi mật khẩu thành công'], 200);
            }else{
                return response()->json(['error' => 'Mật khẩu không giống nhau'], 401);
            }
        }else{
            return response()->json(['error' => 'Mật khẩu của bạn không đúng'], 401);
        }
    }
}
    