<?php

namespace App\Models;

use Database\Factories\ContactUsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class ContactUs extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'contact_us';
    protected $fillable = ['uuid','full_name','email','phone','subject','message','user_id'];
    
    protected $casts = [
        'created_at'    => 'date:Y-m-d h:i:s',
    ];

    public static function boot(){
        parent::boot();        
        static::creating(function ($model) {
            $model->uuid = str_replace('-', '', Uuid::uuid4()->toString());
        });
    }


    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory(){
        return ContactUsFactory::new();
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

}
