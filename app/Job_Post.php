<?php

namespace App;

use App\Company;
use App\Job_type;
use App\Job_level;
use App\Skill_tag;
use App\Job_category;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Notifications\Notifiable;

class Job_Post extends Model
{
    use Notifiable;
    use SearchableTrait;
    protected $table = 'job_post';
    protected $fillable = [
        'company_id','jc_id','jl_id','jt_id','jp_title','jp_location','jp_desc','jp_require','jp_employee_needed','jp_posted_date','jp_expired_date','jp_salary','jp_show_salary','jp_status','jp_slug'
    ];
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */ 
        'columns' => [
            'company.name'=>10,
            'job_level.name' => 10,
            'job_category.name' => 10,
            'skill_tag.st_name' => 20,
            'area.area_name' => 10,
            'job_post.jp_title' => 10,
            'job_post.jp_desc' => 10,
        ],
        'joins' => [
            'job_post_skill_tag'=>['job_post_skill_tag.job_post_id','job_post.id'],
            'skill_tag'=>['job_post_skill_tag.skill_tag_id','skill_tag.id'],
            'company'=>['company.id','job_post.company_id'],
            'job_level'=>['job_post.jl_id','job_level.id'],
            'job_type'=>['job_post.jt_id','job_type.id'],
            'job_category'=>['job_post.jc_id','job_category.id'],
            'area'=>['area.id','job_post.jp_location'],
        ],
        'groupBy'=>'job_post.id'
    ];
    public function postOfCompany(){
        return $this->belongsto(Company::Class, 'company_id', 'id');
    }
    public function postSkillTag(){
        return $this->belongstoMany(Skill_tag::class, 'job_post_skill_tag', 'job_post_id')
        ->withPivot('skill_tag_id', 'job_post_id');
    }
    public function job_type(){
        return $this->hasOne(Job_type::Class, 'id', 'jt_id');
    }
    public function job_level(){
        return $this->hasOne(Job_level::Class, 'id', 'jl_id');
    }
    public function job_category(){
        return $this->hasOne(Job_category::Class, 'id', 'jc_id');
    }
}
