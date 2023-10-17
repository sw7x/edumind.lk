<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Course as CourseModel;
use App\Models\Enrollment as EnrollmentModel;
use App\Models\User as UserModel;
use Illuminate\Database\Eloquent\Builder;

use App\Casts\Percentage;
use Ramsey\Uuid\Uuid;



class Coupon extends Model
{
    use HasFactory;


    const ENABLE 	= 1;
    const DISABLE   = 0;

    protected $fillable = [
        'code',
        'uuid',
        'discount_percentage',
        'beneficiary_commision_percentage_from_discount',
        'total_count',
        'used_count',
        'is_enabled',
        'cc_course_id',
        'beneficiary_id'
    ];

    protected $casts = [
        //'discount_percentage'                             => Percentage::class,
        //'beneficiary_commision_percentage_from_discount'  => Percentage::class,
        //'is_enabled'                                      => 'boolean',
        'discount_percentage'                               => 'float',
        'beneficiary_commision_percentage_from_discount'    => 'float',
        'is_enabled'                                        => 'boolean'

    ];
    

    
    protected $primaryKey 	= 'code';
	public $incrementing 	= false;

    // In Laravel 6.0+ make sure to also set $keyType
    protected $keyType 		= 'string';




    public static function boot(){
        parent::boot();        
        static::creating(function ($model) {
            $model->uuid = str_replace('-', '', Uuid::uuid4()->toString());
        });
    }

    protected static function booted(){
        static::addGlobalScope('enabled', function (Builder $builder) {
            $builder->where('coupons.is_enabled', self::ENABLE);
        });
    }





    public function course()
	{
	    return $this->belongsTo(CourseModel::class, 'cc_course_id', 'id');
	}    

    public function paidCourse()
    {
        return $this->belongsTo(CourseModel::class, 'cc_course_id', 'id')
                    ->where('courses.price', '!=', 0);
    }

    public function beneficiary()
	{
	    return $this->belongsTo(UserModel::class, 'beneficiary_id', 'id');

	}

	/*
    public function enrollments(){
        return $this->hasMany(Enrollment::class,'used_coupon_code','code');
    }
    */
	
    public function course_selections()
    {
        return $this->hasMany(CourseSelectionModel::class,'used_coupon_code','code');        
    }


    public function enrollments()
    {
        return $this->hasManyThrough(
            EnrollmentModel::class,
            CourseSelectionModel::class,
            'used_coupon_code', // Foreign key on the course_selections table...
            'course_selection_id', // Foreign key on the enrollments table...
            'code', // Local key on the coupons table...
            'id' // Local key on the course_selections table...
        );
    }



    /*    
    public function getFirstNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = strtolower($value);
    }
    */
}
