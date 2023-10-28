<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\NotCheckoutScope;



class Cart extends Model
{
    use HasFactory;
    protected $table = 'course_selections';


    protected static function booted(){
        static::addGlobalScope(new NotCheckoutScope);
    }
}
