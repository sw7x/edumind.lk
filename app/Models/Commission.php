<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Enrollment;
use Ramsey\Uuid\Uuid;




class Commission extends Model
{
    use HasFactory;
    
    protected $fillable = ['uuid','image', 'paid_amount', 'paid_date', 'remarks', 'from_date','to_date'];


    public static function boot(){
        parent::boot();
        
        static::creating(function ($model) {
            $model->uuid = str_replace('-', '', Uuid::uuid4()->toString());
        });
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class,'commission_id','id');
    }
}
