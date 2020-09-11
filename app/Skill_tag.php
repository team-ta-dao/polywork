<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill_tag extends Model
{
    //
    protected $table = 'Skill_tag';
    protected $fillable = [
        'st_name','st_slug'
    ]; 
}
