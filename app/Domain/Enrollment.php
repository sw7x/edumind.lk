<?php
namespace App\Domain;


class Enrollment
{
    private $id;
    private $uuid;
    private $isComplete;
    private $completeDate;

    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    public function setIsComplete($isComplete)
    {
        $this->isComplete = $isComplete;
    }

    public function setCompleteDate($completeDate)
    {
        $this->completeDate = $completeDate;
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

    public function getIsComplete()
    {
        return $this->isComplete;
    }

    public function getCompleteDate()
    {
        return $this->completeDate;
    }

    // toArray method
    public function toArray()
    {
        return [
            'id' 			=> $this->id,
            'uuid' 			=> $this->uuid,
            'isComplete' 	=> $this->isComplete,
            'completeDate' 	=> $this->completeDate,
        ];
    }
}


//id
//uuid
course_selection_id
//is_complete
//complete_date
//rating
invoice_id
salary_id
commission_id





created_at
updated_at
