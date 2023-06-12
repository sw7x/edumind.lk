<?php
namespace App\Domain;

use App\Domain\CourseMessage;


class CourseThread
{
    private $id;
    private $uuid;
    
    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }
    

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getUuid()
    {
        return $this->uuid;
    }




    /* associations */
    protected Course $course;
    protected $comments = array();    
    
    public function setCourse(Course $course){
        $this->course = $course;
    }    

    public function getCourse(){
        return $this->course;
    } 



    public function getAllComments(){
        return $this->comments;
    }

    public function setComments(array $comments){
        $this->comments[] = $comments;
    }



    public function addComment(CourseMessage $comments){

    }

    public function removeComment(CourseMessage $comments){
        
    }

    // toArray method
    public function toArray()
    {
        return [
            'id'            => $this->id,
            'uuid'          => $this->uuid,
            
            'course'        => $this->course->toArray(),
            'comments'      => $this->comments
        ];
    }


}



