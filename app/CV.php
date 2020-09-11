<?php

namespace App;

use App\Student;
use Illuminate\Database\Eloquent\Model;

class CV extends Model
{
    //
    protected $table = 'cv';
    protected $fillable = [
        'student_id','title','slug'
    ];
    public function studentUploadCv(){
        return $this->belongsTo(Student::class,'student_id','id');
    }
}
