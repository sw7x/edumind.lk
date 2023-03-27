<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Enrollment;



class Invoice extends Model
{
    use HasFactory;


    public function enrollments()
    {
        return $this->hasMany(Enrollment::class,'invoice_id','id');        
    }
}
