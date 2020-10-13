<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student_major extends Model
{
    //
    protected $table = 'student_major';
    protected $fillable = [
        'name','id'
    ];
    
}
