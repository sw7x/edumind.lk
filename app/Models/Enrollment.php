<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\CheckoutScope;
use App\Models\Invoice;
use App\Models\CourseSelection;
use App\Models\Coupon;

use App\Models\salary;
use App\Models\commission;




class Enrollment extends Model
{
    use HasFactory;

    const CART_ADDED    = 'cart_added';
    const ENROLLED      = 'enrolled';
    const COMPLETED     = 'completed';

    

    protected $table    = 'enrollments';
    protected $fillable = [        
        'course_selection_id',
        'is_complete',
        'complete_date',
        'rating',
        'invoice_id',
        'salary_id',
        'commission_id'
    ];



    public function invoice()
    {
        return $this->belongsTo(Invoice::class,'invoice_id','id');        
    }

    public function courseSelection()
    {
        return $this->belongsTo(CourseSelection::class,'course_selection_id','id');
    }
    


    


    public function coupon()
    {
        return $this->belongsTo(Coupon::class,'used_coupon_code','code');
    }







    public function salary()
    {
        return $this->belongsTo(Salary::class,'salary_id','id');
    }


    public function commission()
    {
        return $this->belongsTo(Commission::class,'commission_id','id');
    }



}
