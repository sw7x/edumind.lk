<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Enrollment;



class Invoice extends Model
{
    use HasFactory;
    
    protected $fillable = [        
        'checkout_date',
        'billing_info'
    ];


    public function enrollments()
    {
        return $this->hasMany(Enrollment::class,'invoice_id','id');        
    }
}
