<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job_Post extends Model
{
    protected $table = 'job_post';
    protected $fillable = [
        'company_id','jc_id','jl_id','jt_id','jp_title','jp_location','jp_desc','jp_require','jp_employee_needed','jp_posted_date','jp_expired_date','jp_salary','jp_show_salary','jp_status','jp_slug'
    ];
}
