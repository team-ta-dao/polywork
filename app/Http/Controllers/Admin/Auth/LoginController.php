<?php

namespace App\Http\Controllers\Admin\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Session;
use App\Admin;
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
        Auth::shouldUse('admin');
    }
    public function getLogin() {
        return view('auth/login');
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
        // config()->set( 'auth.defaults.guard', 'admin' );
        // \Config::set('jwt.user', 'App\Model\Admin\Admin'); 
		// \Config::set('auth.providers.users.model', \App\Model\Admin\Admin::class);
        $remember = $request->has('remember') ? true : false;
        // $credentials = $request->only('username', 'password');
            if (!Auth::attempt(['email'=>$request->email,'password'=>$request->password],$remember)) {
                return redirect()->back()->with('status', 'Email hoặc Password không chính xác');
            }
            else {
                $admin = Admin::query()->where('email',$request->email)->first();
                $request->session()->put('email', $request->email);
                $request->session()->put('username', $admin['username']);
                return redirect('/dashboard');
            }
    }
    public function getChangePassword(){
        return view('auth.passwords.resetpass');
    }
    public function changePassword(Request $request)
    {
        $email = $request->session()->get('email');
        $admin = Admin::query()->where('email',$email)->first();
        $password = $request->password;
        if(Hash::check($password, $admin->password)){
            if($request->password_new  == $request->password_confirm){
                $updateAdmin = Admin::find($admin->id);
                $updateAdmin->password = Hash::make($request->password_new);
                $updateAdmin->save();
                return redirect()->back()->with('success', 'Thay đổi mật khẩu thành công');
            }else{
                return redirect()->back()->with('status', 'Mật khẩu không giống nhau');
            }
        }else{
            return redirect()->back()->with('status', 'Mật khẩu không chính xác');
        }
    }
}
    