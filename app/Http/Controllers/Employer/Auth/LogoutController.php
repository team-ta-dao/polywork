<?php

namespace App\Http\Controllers\Employer\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTFactory;
use JWTAuth;
use JWTAuthException;
use Validator;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Contracts\JWTSubject;
class LogoutController extends Controller
{
    public function __construct()
    {
        Auth::shouldUse('employer');
    }
    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json([
                'success' => true,
                'message' => 'Employer logged out successfully'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the Employer cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
