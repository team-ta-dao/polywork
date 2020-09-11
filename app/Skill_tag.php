<?php

namespace App;

use App\Job_category;
use Illuminate\Database\Eloquent\Model;

class Skill_tag extends Model
{
    //
    protected $table = 'Skill_tag';
    protected $fillable = [
        'st_name','st_slug','jc_id'
    ]; 
    public function TagOfCategory(){
        return $this->belongsTo(Job_category::class, 'jc_id','id');
    }
}
