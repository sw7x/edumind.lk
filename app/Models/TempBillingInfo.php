<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempBillingInfo extends Model
{
    use HasFactory;

    protected $table = 'temp_billing_info';
    protected $fillable = ['user_id','billing_info','is_checkout'];



    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

}




