<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Enrollment as EnrollmentModel;
use Ramsey\Uuid\Uuid;
use App\Models\Casts\Json;


class Invoice extends Model
{
    use HasFactory;

    
    protected $casts = [
        'checkout_date' => 'date:Y-m-d h:i:s',
        'created_at'    => 'date',
        'billing_info'  => Json::class,

    ];

        
    protected $fillable = [        
        'uuid',
        'checkout_date',
        'billing_info',
        'paid_amount'
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
