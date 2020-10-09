<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobBenefit extends Model
{
    protected $table = 'job_benefit';
    protected $fillable = ['id', 'icon', 'name'];
}
