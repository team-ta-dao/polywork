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
/*============STUDENTS============*/    
/*============STUDENTS_LOGIN============*/
Route::post('student/login', 'Student\StudentLogin@login');
Route::group(['prefix' => 'student','middleware' => ['assign.guard:web','jwt.auth']], function(){
    Route::get('/logout', 'Student\StudentLogin@logout');
    Route::get('/profile', 'Student\StudentLogin@getAuthenticatedUser');
    Route::post('/editprofile', 'Student\StudentEditProfile@store');
}); 
/*============STUDENTS_EDIT_PROFILE============*/
