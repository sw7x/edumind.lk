<?php


namespace App\Domain;



class Course{
	public $name;
	public function __construct($name) {
		$this->name = $name;
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




id 
name 
heading_text 
description
image 
status 
topics 
content 
slug 
subject_id ==>FK
teacher_id ==>FK
author_share_percentage 
price
video_count 
duration 

created_at 
updated_at 
//deleted_at










