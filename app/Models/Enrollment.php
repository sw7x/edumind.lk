<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\CheckoutScope;


use App\Models\Invoice as InvoiceModel;
use App\Models\Coupon as CouponModel;
use App\Models\Salary as salaryModel;
use App\Models\CourseSelection as CourseSelectionModel;
use App\Models\Course as CourseModel;
use App\Models\AuthorSalary as AuthorSalaryModel;
use App\Models\Commission as CommissionModel;
use App\Models\User as UserModel;

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
        return $this->belongsTo(InvoiceModel::class,'invoice_id','id');        
    }

    public function courseSelection()
    {
        return $this->belongsTo(CourseSelectionModel::class,'course_selection_id','id');
    }
    

    public function salary()
    {
        return $this->belongsTo(AuthorSalaryModel::class,'salary_id','id');
    }


    public function commission()
    {
        return $this->belongsTo(CommissionModel::class,'commission_id','id');
    }

    public function involvedCourse(){
        //return $this->courseSelection();
        return $this->belongsTo(CourseSelectionModel::class,'course_selection_id','id');
    }


    
    public function ownCourse()
    {
        return $this->belongsToThrough(
            CourseModel::class,
            [CourseSelectionModel::class], 
            null,
            '',
            [
                //EnrollmentModel::class => 'dd',
                CourseModel::class => 'course_id'
                //CourseModel::class => 'xstudent_id'
            ]            
        );
    }
    

    public function usedCoupon()
    {
        return $this->belongsToThrough(
            CouponModel::class,
            [CourseSelectionModel::class], 
            null,
            '',
            [
                //EnrollmentModel::class => 'dd',
                CouponModel::class => 'used_coupon_code'
                //CourseModel::class => 'xstudent_id'
            ]            
        );
    }    


    public function customerStudent()
    {
        return $this->belongsToThrough(
            UserModel::class,
            [CourseSelectionModel::class], 
            null,
            '',
            [
                //EnrollmentModel::class => 'dd',
                UserModel::class => 'student_id'
                //CourseModel::class => 'xstudent_id'
            ]            
        );
    }

  
    public function courseAuthor()
    {
        return $this->belongsToThrough(
            UserModel::class,
            [CourseModel::class, CourseSelectionModel::class], 
            null,
            '',
            [
                // db table   => foreign key of other table
                UserModel::class => 'teacher_id',
                CourseModel::class => 'course_id',
                CourseSelectionModel::class => 'course_selection_id',

            ]           
        );
    }

    public function beneficiary()
    {
        return $this->belongsToThrough(
            UserModel::class,
            [CouponModel::class, CourseSelectionModel::class ], 
            null,
            '',
            [
                // db table   => foreign key of other table
                UserModel::class => 'beneficiary_id',
                CouponModel::class => 'used_coupon_code',
                CourseSelectionModel::class => 'course_selection_id',
            ]            
        );
        //no need
        //->where('coupons.is_enabled', 1)
        //->whereColumn('coupons.total_count', '>', 'coupons.used_count');      
    }    

}
