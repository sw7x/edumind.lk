<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Enrollment as EnrollmentModel;
use Ramsey\Uuid\Uuid;



class Invoice extends Model
{
    use HasFactory;

    
    protected $casts = [
        'checkout_date' => 'date:Y-m-d h:i:s',
        'created_at'    => 'date',
    ];

        
    protected $fillable = [        
        'uuid',
        'checkout_date',
        'billing_info'
    ];

    

    public static function boot(){
        parent::boot();        
        static::creating(function ($model) {
            $model->uuid = str_replace('-', '', Uuid::uuid4()->toString());
        });
    }
    
    public function enrollments()
    {
        return $this->hasMany(EnrollmentModel::class,'invoice_id','id');        
    }


    


    
}
