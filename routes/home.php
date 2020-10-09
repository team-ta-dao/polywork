<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('send/area','Information@sendAllArea');
Route::post('send/district','Information@sendAllDistrict');
