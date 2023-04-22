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

    protected $fillable = [  
        'cart_added_date',
        'is_checkout',
        'course_id',
        'student_id',

        'edumind_amount ',
        'author_amount ',
        'used_coupon_code',
        'discount_amount',
        'price_afeter_discouunt',
        'edumind_lose_amount',
        'benificiary_earn_amount'
    ];


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
