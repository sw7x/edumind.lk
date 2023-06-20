<?php
namespace App\Domain;

use App\Domain\CourseItem;
use App\Domain\Order;


class Enrollment
{
    private $id;
    private $uuid;
    private $isComplete;
    private $completeDate;
    private $rating;


    public function __construct(CourseItem $courseItem) {
        $this->courseItem   = $courseItem;
        // $this->order        = $order;
    }


    /* compositions */
    protected CourseItem $courseItem;
    protected Order $order;
    protected Student $student;




    /* associations */
    protected AuthorFee $authorFee = null; 
    protected CommissionFee $commissionFee = null; 
    protected EdumindFee $edumindFee = null;
    protected ContactUsMessage $contactUsMessages = array();
    
    
    
    public function setAuthorFee(AuthorFee $authorFee){
        $this->authorFee = $authorFee;
    }    

    public function getAuthorFee(){
        return $this->authorFee;
    }     


    public function setCommissionFee(CommissionFee $commissionFee){
        $this->commissionFee = $commissionFee;
    }    

    public function getCommissionFee(){
        return $this->commissionFee;
    }

    public function setEdumindFee(EdumindFee $edumindFee){
        $this->edumindFee = $edumindFee;
    }

    public function getEdumindFee(){
        return $this->edumindFee;
    }


    public function setContactUsMessages(ContactUsMessage $contactUsMessages){
        $this->contactUsMessages = $contactUsMessages;
    }    

    public function getContactUsMessages(){
        return $this->contactUsMessages;
    } 

























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

    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    public function setOrder(Order $order)
    {
        $this->order = $order;
    }

    public function setStudent(Student $student)
    {
        $this->student = $student;
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

    public function getCompleteDate()
    {
        return $this->completeDate;
    }    

    public function getRating()
    {
        return $this->rating;
    }    

    public function getCourseItem()
    {
        return $this->courseItem;
    }    

    public function getOrder()
    {
        return $this->order;
    }

    public function setStudent(){
        return $this->student;
    }




    // toArray method
    public function toArray()
    {
        return [
            'id' 			=> $this->id,
            'uuid' 			=> $this->uuid,
            'isComplete' 	=> $this->isComplete,
            'completeDate' 	=> $this->completeDate,
            'rating'        => $this->rating,

            'courseItem'    => $this->courseItem->toArray(),
            'order'         => $this->order->toArray(),

            'authorFee'         => $this->authorFee->toArray(); 
            'commissionFee'     => $this->commissionFee->toArray(); 
            'edumindFee'        => $this->edumindFee->toArray();
            'contactUsMessages' => $this->contactUsMessages;
        ];
    }














}


/*

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


*/
