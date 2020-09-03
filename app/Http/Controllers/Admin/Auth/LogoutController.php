<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Request;
use Illuminate\Support\Facades\Auth;
use Session;

class LogoutController extends Controller
{
    public function __construct() {
    	$this->middleware('auth');
    }
		
	public function getLogout() {
        Auth::guard('admin')->logout();
        Request::session()->flush();
        return redirect('admin\login');
	}
}
