<?php

namespace App\Models;

use Database\Factories\ContactUsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact_us extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'contact_us';
    protected $fillable = ['full_name','email','phone','subject','message','user_id'];

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
