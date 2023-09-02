<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\CheckoutScope;


use App\Models\Invoice;
use App\Models\Coupon;
use App\Models\salary;
use App\Models\commission;
use App\Models\CourseSelection;
use App\Models\Course;
use Ramsey\Uuid\Uuid;



class Enrollment extends Model
{
    use HasFactory;
    use \Znck\Eloquent\Traits\BelongsToThrough;

    const CART_ADDED    = 'cart_added';
    const ENROLLED      = 'enrolled';
    const COMPLETED     = 'completed';

        
    protected $casts = [
        'is_complete'    => 'boolean',
    ];


    protected $table    = 'enrollments';
    protected $fillable = [        
        'uuid',
        'course_selection_id',
        'is_complete',
        'complete_date',
        'rating',
        'invoice_id',
        'salary_id',
        'commission_id'
    ];

    


    public static function boot(){
        parent::boot();        
        static::creating(function ($model) {
            $model->uuid = str_replace('-', '', Uuid::uuid4()->toString());
        });
    }





    public function invoice()
    {
        return $this->belongsTo(Invoice::class,'invoice_id','id');        
    }

    public function courseSelection()
    {
        return $this->belongsTo(CourseSelection::class,'course_selection_id','id');
    }
    

    public function salary()
    {
        return $this->belongsTo(AuthorSalary::class,'salary_id','id');
    }


    public function commission()
    {
        return $this->belongsTo(Commission::class,'commission_id','id');
    }





    public function carOwner()
    {
        return $this->hasOneThrough(Owner::class, Car::class);
    }

    
    public function involvedCourse(){
        //return $this->courseSelection();
        return $this->belongsTo(CourseSelection::class,'course_selection_id','id');
    }



    
    public function ownCourse()
    {
        return $this->belongsToThrough(
            Course::class,
            [CourseSelection::class], 
            null,
            '',
            [
                //Enrollment::class => 'dd',
                Course::class => 'course_id'
                //Course::class => 'xstudent_id'
            ]            
        );
    }
    

    public function usedCoupon()
    {
        return $this->belongsToThrough(
            Coupon::class,
            [CourseSelection::class], 
            null,
            '',
            [
                //Enrollment::class => 'dd',
                Coupon::class => 'used_coupon_code'
                //Course::class => 'xstudent_id'
            ]            
        );
    }    


    public function customerStudent()
    {
        return $this->belongsToThrough(
            User::class,
            [CourseSelection::class], 
            null,
            '',
            [
                //Enrollment::class => 'dd',
                User::class => 'student_id'
                //Course::class => 'xstudent_id'
            ]            
        );
    }

  
    public function courseAuthor()
    {
        return $this->belongsToThrough(
            User::class,
            [Course::class, CourseSelection::class], 
            null,
            '',
            [
                // db table   => foreign key of other table
                User::class => 'teacher_id',
                Course::class => 'course_id',
                CourseSelection::class => 'course_selection_id',

            ]           
        );
    }

    public function beneficiary()
    {
        return $this->belongsToThrough(
            User::class,
            [Coupon::class, CourseSelection::class ], 
            null,
            '',
            [
                // db table   => foreign key of other table
                User::class => 'beneficiary_id',
                Coupon::class => 'used_coupon_code',
                CourseSelection::class => 'course_selection_id',
            ]            
        );
        //no need
        //->where('coupons.is_enabled', 1)
        //->whereColumn('coupons.total_count', '>', 'coupons.used_count');      
    }


    

}
