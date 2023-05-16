<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Casts\Json;
use App\Models\CourseSelection;
use App\Models\Coupon;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Support\Facades\Storage;

class Course extends Model
{
    use HasFactory,Sluggable;

    const PUBLISHED = 'published';
    const DRAFT     = 'draft';
    
    
    protected $casts = [
        //'topics'  => 'array',
        'topics'  => Json::class,
        //'content' => 'array',
        'content' => Json::class,

    ];

    protected $fillable = [
        'name',
        'subject_id',
        'teacher_id',
        'heading_text',
        'description',
        'duration',
        'video_count',
        'author_share_percentage',
        'price',
        'status',
        'image',
        'topics', 
        'content',
        'slug'
    ];





    
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


    /*public function getContentAttribute($value)
    {
        //return $value;
        //return stripslashes($value);
        //return "getContentAttribute";
        //$rr = stripslashes($value);
        //return $rr;
        //dump($value);
        //return json_decode($value, true, 512, JSON_THROW_ON_ERROR);
        //dump($rr);
        //return  json_decode($rr, true, 512, JSON_THROW_ON_ERROR);
        //return json_decode($value, true, 512, JSON_UNESCAPED_SLASHES);


        if($value){
            return json_decode($value, true, 512, JSON_THROW_ON_ERROR);
        }else{
            return "";
        }   



    }

    
    public function getTopicsAttribute($value)
    {   
        if($value){
            return  json_decode($value ?? "{}", true, 512, JSON_THROW_ON_ERROR);
        }else{
            return "";
        }        
    }*/


    protected static function booted(){
        static::addGlobalScope('published', function (Builder $builder) {
            $builder->where('courses.status', self::PUBLISHED);
        });
    }


    
    public function getImageAttribute($value){
        
        if($value){           
            $imagePath = asset('storage/'.$value);
        }else{
            $imagePath = asset('images/default-images/course.png');           
        }

        return $imagePath;
    }





    public function subject(){
        return $this->belongsTo(Subject::class,'subject_id','id');
    }

    public function teacher(){
        return $this->belongsTo(User::class,'teacher_id','id');
    }

    public function course_selections()
    {
        return $this->hasMany(CourseSelection::class,'course_id','id');        
    }

    public function coupons()
    {
        return $this->hasMany(Coupon::class,'cc_course_id','id');
    }

    public function activeCoupons()
    {
        return $this->hasMany(Coupon::class,'cc_course_id','id')
                    ->whereColumn('coupons.total_count', '>', 'coupons.used_count')
                    ->where('coupons.discount_percentage','!=',0);
    }


    public function getLastUpdatedTime(){
        return Carbon::parse($this->updated_at)->diffForHumans();
    }

    public function getCreatedTime(){
        return Carbon::parse($this->created_at)->diffForHumans();
    }

    public function isEmpty(){       
        
        //dd($this->topics);
        if(!$this->content){
            return true;
        }else{
            return empty($this->content);
        }

        
    }

    public function getLinkCount(){
        $courseLinkCount = 0;
        foreach($this->content as $arr){
            $courseLinkCount += count($arr);
        }
        return $courseLinkCount;
    }


    public function getVideoSectionId($vid){
        //dd($this->content);
        $sectionId = -1;
        $videoId = 0;
        $result = -1;

        foreach($this->content as $val){
            $sectionId++;
            foreach($val as $arr){
                $videoId++;
                if($videoId == $vid){
                    //return $sectionId;
                    $result = $sectionId;
                }
            }
        }

        return $result;
        //dump("vid - {$vid} === section- {$result}");
    }




}
