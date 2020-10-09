<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job_Benefit extends Model
{
    //
    protected $table = "job_benefit";

    protected $fillable = ['id', 'icon', 'name'];
}
