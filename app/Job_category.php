<?php

namespace App;

use App\Skill_tag;
use Illuminate\Database\Eloquent\Model;

class Job_category extends Model
{
    //
    protected $table = 'job_category';
    protected $fillable = [
        'name','desc','slug','id'
    ];

    public function getCategoryOfCompany()
    {
        return $this->belongsTo(Company::class, 'id');
    }
}
