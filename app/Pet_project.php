<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pet_project extends Model
{
    //
    protected $table = "pet_projects";
    protected $fillable = [
        'student_id','name','description','url','thumb'
    ];
}
