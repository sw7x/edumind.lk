<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;


class Coupon extends Model
{
    use HasFactory;
    
    protected $primaryKey 	= 'code';
	public $incrementing 	= false;

    // In Laravel 6.0+ make sure to also set $keyType
    protected $keyType 		= 'string';


    public function course()
	{
	    return $this->belongsTo(Course::class, 'course_id', 'id');
	}

    public function benificiary()
	{
	    return $this->belongsTo(User::class, 'beneficiary_id', 'id');
	}

	public function enrollments()
    {
        return $this->hasMany(Enrollment::class,'used_cupon_code','code');
    }
	


}
