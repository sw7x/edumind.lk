<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;


class Course extends Model
{
    use HasFactory,Sluggable;
    
    protected $casts = [
        //'topics'  => 'array',
        //'content' => 'array',
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


    public function getContentAttribute($value)
    {
        //return $value;
        //return stripslashes($value);
        //return "getContentAttribute";
        //$rr = stripslashes($value);
        //return $rr;
        //dump($value);
        return json_decode($value, true, 512, JSON_THROW_ON_ERROR);
        //dump($rr);
        //return  json_decode($rr, true, 512, JSON_THROW_ON_ERROR);
        //return json_decode($value, true, 512, JSON_UNESCAPED_SLASHES);
    }

    
    public function getTopicsAttribute($value)
    {
        //return 'getTopicsAttribute';
        return  json_decode($value, true, 512, JSON_THROW_ON_ERROR);
    }


    public function subject(){
        return $this->belongsTo(Subject::class,'subject_id','id');
    }

    public function teacher(){
        return $this->belongsTo(User::class,'teacher_id','id');
    }

    public function students()
    {
        return $this->belongsToMany('App\Models\User',
            'enrollments',
            'course_id',
            'student_id')
            ->withPivot(
                'cart_add_date',
                'enroll_date',
                'complete_date',
                'discount_amount',
                'rating',
                //'course_id',
                //'student_id',
                'comment_id',
                'status'
            )->withTimestamps();
    }




    public function getLastUpdatedTime(){
        return Carbon::parse($this->updated_at)->diffForHumans();
    }

    public function getCreatedTime(){
        return Carbon::parse($this->created_at)->diffForHumans();
    }

    public function isEmpty(){
        return empty(json_decode($this->topics,true));
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
