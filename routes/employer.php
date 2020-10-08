<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*============EMPLOYER============*/    
/*============EMPLOYERS_LOGIN============*/
Route::post('employer/login', 'Employer\Auth\LoginController@login');
/*============EMPLOYERS_LOGIN============*/
Route::post('employer/register', 'Employer\Auth\RegisterController@postRegister');
Route::group(['prefix' => 'employer','namespace'=>'Employer','middleware' => ['assign.guard:employer','jwt.auth']], function(){
    /*============EMPLOYER_CHANGE_PASSWORD============*/
    /*============EMPLOYER->REQUEST->EMAIL->TOKEN($TOKEN)->PASSWORD->PASSWORD_NEW->PASSWORD_OLD============*/
    Route::post('/changepassword', 'Auth\LoginController@changePassword');
    /*============EMPLOYER_LOGOUT============*/
    Route::get('/logout', 'Auth\LogoutController@logout');
    /*============EMPLOYER_GET_PROFILE============*/
    // Route::get('/profile', 'EmployerEditProfile@index');
    // /*============EMPLOYER_EDIT_PROFILE============*/
    // Route::post('/profile', 'EmployerEditProfile@update');
    Route::resource('/profile', 'EmployerEditProfile')->only([
        'index','store'
    ]);
});
/*============EMLOYER_RESET_PASSWORD_WITH_EMAIL============*/
Route::post('employer/password/email', 'Employer\Auth\ForgotPasswordController@sendResetLinkEmail');
Route::post('employer/password/reset', 'Employer\Auth\ResetPasswordController@reset');
// Route::post('employer/reset-password', 'Employer\Auth\ResetPasswordController@sendMail');
// Route::post('employer/reset-password/{token}', 'Employer\Auth\ResetPasswordController@reset');