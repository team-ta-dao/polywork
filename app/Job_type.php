<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job_type extends Model
{
    //
    protected $table = 'job_type';
    protected $fillable = [
        'name','slug'
    ];
}
