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
Route::post('student/suggestion','Student\SuggestionStudent@Suggestion');
Route::group(['prefix' => 'student','namespace'=>'Student','middleware' => ['assign.guard:web','jwt.auth']], function(){
    /*============STUDENTS_LOGOUT============*/
    Route::get('/logout', 'StudentLogin@logout');
    /*============STUDENTS_GET_PROFILE============*/
    Route::get('/profile', 'StudentEditProfile@index');
    /*============STUDENTS_EDIT_PROFILE============*/
    Route::post('/profile', 'StudentEditProfile@store');
    /*============STUDENTS_CHANGE_PASSWORD_IS_LOGIN============*/
    // Route::resource('/profile', 'StudentEditProfile')->only([
    //     'index','store','destroy'
    // ]);
    Route::post('/upload_project','StudentEditProfile@multiUploadPetProject');
    Route::post('/upload_cv','StudentEditProfile@multiUploadCv');
    Route::post('/changepassword', 'StudentLogin@UserisRessetPassword');
}); 