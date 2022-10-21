<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;


class Subject extends Model
{
    use HasFactory;
    use Sluggable;
    protected $table = 'subjects';
    protected $fillable = ['name','description','image','status','slug'];



    public function courses(){
        return $this->hasMany(Course::class,'subject_id','id');
    }



    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

}
