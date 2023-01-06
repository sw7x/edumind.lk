<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    const CART_ADDED    = 'cart_added';
    const ENROLLED      = 'enrolled';
    const COMPLETED     = 'completed';

    

    protected $table    = 'enrollments';
    protected $fillable = [
        'cart_add_date',
        'enroll_date',
        'complete_date',
        'discount_amount',
        'rating',
        'course_id',
        'student_id',
        'comment_id',
        'status'
    ];

}
