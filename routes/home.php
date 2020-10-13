<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('send/area','Information@sendAllArea');
Route::post('send/district','Information@sendAllDistrict');
Route::post('send/nation','Information@sendAllNation');
Route::post('send/tag','Information@getAllTag');
Route::post('send/category','Information@getAllCategory');
Route::post('send/major','Information@getAllMajor');

