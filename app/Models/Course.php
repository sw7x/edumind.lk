<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $casts = [
        'topics'  => 'array',
        'content' => 'array',
    ];

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
