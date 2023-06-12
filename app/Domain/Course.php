<?php
namespace App\Domain;

use App\Domain\Subject;


//subject_id ==>FK
//teacher_id ==>FK



class Course
{
    private $id;
    private $uuid;
    private $name;
    private $description;
    private $image;
    private $headingText;
    private $topics;
    private $content;
    private $slug;
    private $authorSharePercentage;
    private $price;
    private $videoCount;
    private $duration;
    private $status;    


    /* associations */
    protected Subject $subject;
    protected Teacher $author;
    protected CourseThread $courseThread;

    public function setSubject(Subject $subject){
        $this->subject = $subject;
    }    

    public function getSubject(){
        return $this->subject;
    }   

    public function setAuthor(Teacher $techer){
        $this->author = $techer;
    }    

    public function getAuthor(){
        return $this->author;
    }    

    public function setCourseThread(CourseThread $courseThread){
        $this->courseThread = $courseThread;
    }    

    public function getCourseThread(){
        return $this->courseThread;
    }



    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getUuid(){
        return $this->uuid;
    }

    public function setUuid($uuid){
        $this->uuid = $uuid;
    }

    public function getName(){
        return $this->name;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function getDescription(){
        return $this->description;
    }

    public function setDescription($description){
        $this->description = $description;
    }

    public function getImage(){
        return $this->image;
    }

    public function setImage($image){
        $this->image = $image;
    }

    public function getHeadingText(){
        return $this->headingText;
    }

    public function setHeadingText($headingText){
        $this->headingText = $headingText;
    }

    public function getTopics(){
        return $this->topics;
    }

    public function setTopics($topics){
        $this->topics = $topics;
    }

    public function getContent(){
        return $this->content;
    }

    public function setContent($content){
        $this->content = $content;
    }

    public function getSlug(){
        return $this->slug;
    }

    public function setSlug($slug){
        $this->slug = $slug;
    }

    public function getAuthorSharePercentage(){
        return $this->authorSharePercentage;
    }

    public function setAuthorSharePercentage($authorSharePercentage){
        $this->authorSharePercentage = $authorSharePercentage;
    }

    public function getPrice(){
        return $this->price;
    }

    public function setPrice($price){
        $this->price = $price;
    }

    public function getVideoCount(){
        return $this->videoCount;
    }

    public function setVideoCount($videoCount){
        $this->videoCount = $videoCount;
    }

    public function getDuration(){
        return $this->duration;
    }

    public function setDuration($duration){
        $this->duration = $duration;
    }

    public function getStatus(){
        return $this->status;
    }

    public function setStatus($status){
        $this->status = $status;
    }

    public function toArray(){
        return [
            'id'                    => $this->id,
            'uuid'                  => $this->uuid;
            'name'                  => $this->name,
            'description'           => $this->description,
            'image'                 => $this->image,
            'headingText'           => $this->headingText,
            'topics'                => $this->topics,
            'content'               => $this->content,
            'slug'                  => $this->slug,
            'authorSharePercentage' => $this->authorSharePercentage,
            'price'                 => $this->price,
            'video_count'           => $this->videoCount,
            'duration'              => $this->duration,
            'status'                => $this->status,
            
            'subject'               => $this->subject->toArray(),
            'author'                => $this->author->toArray(),
            'courseThread'          => $this->courseThread->toArray()
        ];
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


    


    
    public function dummyMethod(){
        //dd($this->content);
        $sectionId = -1;
        $videoId = 0;
        $result = -1;
        
        $subject = $this->subject;
        $teacher = $this->teacher;
        $rrt = 0;
        foreach($this->content as $val){
            $sectionId++;
            $rrt = $teacher->authorSharePercentage($subject->descriptionAwe());
            foreach($val as $arr){
                $rrt += $videoId;
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






    /* 

    public function getLastUpdatedTime(){
        return Carbon::parse($this->updated_at)->diffForHumans();
    }

    public function getCreatedTime(){
        return Carbon::parse($this->created_at)->diffForHumans();
    }
    
    */

    public function makePublish(){
        $this->status = true;  
    }
    public function makeDraft(){
        $this->status = false;         
    }

    /*
    public function approve(){

    }
    public function unapprove(){

    }
    */

    public function calculateEdumindEarnAmount(int $discountPrecentage, int $commissionPrecentage){
        $coursePrice        = $this->price;        
        $edumindAmount      = $coursePrice * ((100 - $this->author_share_percentage)/100);
        $discountAmount     = ($coursePrice * ($discountPrecentage/100));
        $edumindLoseAmount  = ($discountAmount/100) * (100 + $commissionPrecentage);
        return ($edumindAmount - $edumindLoseAmount);
    }






}



