<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// SET HEADER X-Authorization: dfqRceOMJzOnatZVDmNsPjB1GEe5rZ94XnNkww6UOhPJUHX4ZqnLzp4hAQIa4CIg
Route::group(['prefix' => 'send','middleware' => 'auth.apikey'], function(){
        /*============SEND_ALL_AREA============*/
    Route::post('area','Information@sendAllArea');
        /*============SEND_ALL_DISTRICT============*/
    Route::post('district','Information@sendAllDistrict');
        /*============SEND_ALL_NATION============*/
    Route::post('nation','Information@sendAllNation');
        /*============SEND_ALL_TAG============*/
    Route::post('tag','Information@getAllTag');
        /*============SEND_ALL_CATEGORY============*/
    Route::post('category','Information@getAllCategory');
        /*============SEND_ALL_MAJOR============*/
    Route::post('major','Information@getAllMajor');
            /*============SEACH_BY_TAG============*/
    Route::get('tag/{slug}','SearchByAuthLogin@searchBySkillTag');
      /*============SEACH_BY_CATEGORY============*/
    Route::get('cate/{slug}','SearchByAuthLogin@searchByCategory');
    Route::post('fulltext','SearchByAuthLogin@searchFullText');
});