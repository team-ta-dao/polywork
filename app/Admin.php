<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    //
    use Notifiable;
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $table = 'admin';
    protected $fillable = [
        'email','password','admin_fullname','admin_avatar','admin_dob','admin_phone_num'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
}
