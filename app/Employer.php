<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    protected $table = 'employer';
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $fillable = [
       'fullname','email','phone_num','avatar'
   ];
}
