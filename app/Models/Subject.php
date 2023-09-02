<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Ramsey\Uuid\Uuid;


class Subject extends Model
{
    use HasFactory;
    use Sluggable;

    const PUBLISHED = 'published';
    const DRAFT     = 'draft';

    
    protected $table = 'subjects';
    protected $fillable = ['name','uuid','description','image','status','slug','author_id'];



    public static function boot(){
        parent::boot();        
        static::creating(function ($model) {
            $model->uuid = str_replace('-', '', Uuid::uuid4()->toString());
        });
    }







    protected static function booted(){
        static::addGlobalScope('published', function (Builder $builder) {
            $builder->where('subjects.status', self::PUBLISHED);
        });
    }


    public function getImageAttribute($value){
        
        if($value){           
            $imagePath = asset('storage/'.$value);
        }else{
            $imagePath = asset('images/default-images/subject.png');           
        }
        return $imagePath;
    }





    public function courses(){
        return $this->hasMany(Course::class,'subject_id','id');
    }

    public function creator(){
        return $this->belongsTo(User::class,'author_id','id');
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
