<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable implements JWTSubject
{
    use Notifiable;
    protected $table = 'student';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fullname','username', 'email', 'bio','address','phone_num','password','student_code'
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
    public function getDetail($id){
        $student = DB::table('student')->where('student.id',$id)
        ->join('job_level','job_level.id','=','student.jl_id')
        ->join('district' ,'district.id','=','student.area_id')
        ->join('gender','gender.id','=','student.gender_id')
        ->select('student.email','student.fullname','student.student_code','student.bio','student.dob','student.address','student.phone_num', 'job_level.*', 'district.*','gender.*')
        ->get();
        return $student;
    }
}
