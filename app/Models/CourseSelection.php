<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Course as CourseModel;
use App\Models\User as UserModel;
use App\Models\Coupon as CouponModel;
use App\Models\Enrollment as EnrollmentModel;
use Ramsey\Uuid\Uuid;


class CourseSelection extends Model
{
    use HasFactory;
    //public $timestamps = false;
    //use SoftDeletes;

    protected $fillable = [  
        'uuid',
        'cart_added_date',
        'is_checkout',
        'course_id',
        'student_id',

        'edumind_amount',
        'author_amount',
        'used_coupon_code',
        'discount_amount',
        'revised_price',
        'edumind_lose_amount',
        'beneficiary_earn_amount'
    ];

    protected $casts = [
        'is_checkout'    => 'boolean',
    ];

       
    public static function boot(){
        parent::boot();        
        static::creating(function ($model) {
            $uuid = str_replace('-', '', Uuid::uuid4()->toString());
            $model->uuid = $uuid;
        });
    }


    public function course()
    {
        return $this->belongsTo(CourseModel::class,'course_id','id');        
    }

    public function student()
    {
        return $this->belongsTo(UserModel::class,'student_id','id');        
    }

    public function enrollment()
    {
        return $this->hasOne(EnrollmentModel::class,'course_selection_id','id');
    }

    public function coupon()
    {
        return $this->belongsTo(CouponModel::class,'used_coupon_code','code');
    }

}
