<?php

namespace App;

use App\CV;
use App\Job_level;
use App\Skill_tag;
use App\Pet_project;
use App\Student_major;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable implements JWTSubject
{
    use Notifiable;
    // use SearchJob;
    protected $table = 'student';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fullname','username', 'email', 'bio','address','phone_num','password','student_code','student_major_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array   
     */
    protected $hidden = [
        'remember_token','password'
    ];
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function student_skill(){
        return $this->belongsToMany(Skill_tag::class);
    }
    public function student_cv(){
        return $this->hasMany(CV::class);
    }
    public function student_pet_project(){
        return $this->hasMany(Pet_project::class);
    }
    public function student_major(){
        return $this->belongsTo(Student_major::class, 'student_major_id','id');
    }
    public function student_job_level(){
        return $this->belongsTo(Job_level::class, 'jl_id','id');
    }
    public function student_search_job(){
        
    }
}
