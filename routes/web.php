<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
// Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
//     Route::get('/login', 'Auth\LoginController@getLogin');
//     Route::post('/login', 'Auth\LoginController@login');
//     // Route::post('logout', 'Auth\LoginController@logout');
// });
/*============ADMIN============*/
/*============ADMIN_LOGIN============*/
Route::get('login', [ 'as' => 'login','prefix' => 'admin', 'uses' => 'Admin\Auth\LoginController@getLogin']);
Route::post('login', [ 'as' => 'login','prefix' => 'admin', 'uses' => 'Admin\Auth\LoginController@login']);
/*============ADMIN_REGISTER============*/
Route::get('register',['as' => 'register','prefix' => 'admin','uses'=> 'Admin\Auth\RegisterController@getRegister']);
Route::post('register',['as' => 'register','prefix' => 'admin','uses'=> 'Admin\Auth\RegisterController@postRegister']);
/*============ADMIN_LOGOUT============*/
Route::post('logout', [ 'as' => 'logout','prefix' => 'admin','uses' => 'Admin\Auth\LogoutController@getLogout']);
/*============ADMIN_CHANGE_PASSWORD============*/
Route::get('changepassword',['as' => 'changepassword','prefix' => 'admin','uses'=> 'Admin\Auth\LoginController@getChangePassword']);
Route::post('changepassword',['as' => 'changepassword','prefix' => 'admin','uses'=> 'Admin\Auth\LoginController@changePassword']);
/*============ADMIN_RESET_PASSWORD_WITH_EMAIL============*/
Route::post('/password/email', 'Admin\Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::get('/password/reset', 'Admin\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('/password/reset', 'Admin\Auth\ResetPasswordController@reset');
Route::get('/password/reset/{token}', 'Admin\Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');
