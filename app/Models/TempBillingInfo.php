<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User as UserModel;

class TempBillingInfo extends Model
{
    use HasFactory;

    protected $table = 'temp_billing_info';
    protected $fillable = ['user_id','billing_info','is_checkout'];



    public function user(){
        return  $this->belongsTo(UserModel::class,'user_id','id')
                    ->withoutGlobalScope('active')
                    ->withTrashed();
    }

}




