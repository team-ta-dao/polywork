<?php

namespace App;

use App\CV;
use App\Skill_tag;
use App\Pet_project;
use App\Traits\SearchJob;
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
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'users.first_name' => 10,
            'users.last_name' => 10,
            'users.bio' => 2,
            'users.email' => 5,
            'posts.title' => 2,
            'posts.body' => 1,
        ],
        'joins' => [
            'posts' => ['users.id','posts.user_id'],
        ],
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
}
