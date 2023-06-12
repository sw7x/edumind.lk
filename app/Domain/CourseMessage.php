<?php
namespace App\Domain;




//subject_id ==>FK
//teacher_id ==>FK



class CourseMessage
{
    private $id;
    private $uuid;
    private $postedDateTime;
    private $message;



    // Getters
    public function getId() {
        return $this->id;
    }

    public function getUuid() {
        return $this->uuid;
    }

    public function getPostedDateTime() {
        return $this->postedDateTime;
    }

    public function getMessage() {
        return $this->message;
    }



    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setUuid($uuid) {
        $this->uuid = $uuid;
    }

    public function setPostedDateTime($postedDateTime) {
        $this->postedDateTime = $postedDateTime;
    }

    public function setMessage($message) {
        $this->message = $message;
    }




    // toArray method
    public function toArray(){
        return [
            'id'            => $this->id,
            'uuid'          => $this->uuid,
            'postedDateTime'=> $this->postedDateTime,
            'message'       => $this->completeDate            
        ];
    }


}



