<?php

namespace App;

use App\Employer;
use App\Job_Post;
use App\Job_category;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPasswordRequestEmployer;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Company extends Authenticatable implements JWTSubject
{
    use Notifiable;
    protected $table = 'company';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email','nation_id','jc_id','area_id','as_id','password', 'name', 'address','cover_img','desc','slogan','id'
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
    // public function belongsTo()
    // {
    // 	return $this->hasOne(Employer::class);
    // }
    public function CategoryCompany()
    {
        return $this->hasOne(Job_category::class, 'id','jc_id');
    }
    public function EmployerIsCompany()
    {
        return $this->hasOne(Employer::class);
    }
    
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordRequestEmployer($token));
    }
    public function company_job_post()
    {
        return $this->hasMany(Job_Post::class);
    }
}