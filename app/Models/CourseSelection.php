<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Course;
use App\Models\User;

use App\Models\Enrollment;

class CourseSelection extends Model
{
    use HasFactory;
    public $timestamps = false;



    public function course()
    {
        return $this->belongsTo(Course::class,'course_id','id');        
    }

    public function student()
    {
        return $this->belongsTo(User::class,'student_id','id');        
    }

    public function enrollment()
    {
        return $this->hasOne(Enrollment::class,'course_selection_id','id');
    }
}
