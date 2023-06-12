<?php


namespace App\Domain;

use App\Domain\Types\CouponCodeTypesEnum;
use App\Domain\Exceptions\DomainException;


//created_at 
//updated_at 
//deleted_at

class CouponCode
{
    private $code;
    private $uuid;
    private $discountPercentage;
    private $commisionPercentageFromDiscount;
    private $totalCount;
    private $usedCount;
    private $isEnabled;
    
    /* composition */
    protected Course $course;
    protected User $benificiary;


    public function __construct(Course $course = null, User $benificiary) {
        $this->course = $course;
        $this->benificiary = $benificiary;
    }
    


    /*public function setCourse(Course $course){
        $this->course = $course;
    }*/    

    public function getCourse(){
        return $this->course;
    }   

    /*public function setBenificiary(User $benificiary){
        $this->benificiary = $benificiary;
    }*/    

    public function getBenificiary(){
        return $this->benificiary;
    }





    

    // Setters
    public function setCode($code)
    {
        $this->code = $code;
    }

    public function setDiscountPercentage($discountPercentage)
    {
        $this->discountPercentage = $discountPercentage;
    }

    public function setCommisionPercentageFromDiscount($commisionPercentageFromDiscount)
    {
        $this->commisionPercentageFromDiscount = $commisionPercentageFromDiscount;
    }

    public function setTotalCount($totalCount)
    {
        $this->totalCount = $totalCount;
    }

    public function setUsedCount($usedCount)
    {
        $this->usedCount = $usedCount;
    }

    public function setIsEnabled($isEnabled)
    {
        $this->isEnabled = $isEnabled;
    }

    public function setCourseId($courseId)
    {
        $this->courseId = $courseId;
    }

    public function setBeneficiaryId($beneficiaryId)
    {
        $this->beneficiaryId = $beneficiaryId;
    }

    // Getters
    public function getDiscountPercentage()
    {
        return $this->discountPercentage;
    }

    public function getCommisionPercentageFromDiscount()
    {
        return $this->commisionPercentageFromDiscount;
    }

    public function getTotalCount()
    {
        return $this->totalCount;
    }

    public function getUsedCount()
    {
        return $this->usedCount;
    }

    public function getIsEnabled()
    {
        return $this->isEnabled;
    }

    public function getCourseId()
    {
        return $this->courseId;
    }

    public function getBeneficiaryId()
    {
        return $this->beneficiaryId;
    }






    // toArray method
    public function toArray()
    {
        return [
            'code'                              => $this->code,
            'discountPercentage'                => $this->discountPercentage,
            'commisionPercentageFromDiscount'   => $this->commisionPercentageFromDiscount,
            'totalCount'                        => $this->totalCount,
            'usedCount'                         => $this->usedCount,
            'isEnabled'                         => $this->isEnabled,
            
            'course'                            => $this->course->toArray(),
            'benificiary'                       => $this->beneficiary->toArray(),
        ];
    }


    public function getCouponType(){
        return $this->course ? 
            CouponCodeTypesEnum::SINGLE_COURSE : 
            CouponCodeTypesEnum::ANY_COURSE;
    }

    public function getAvailableCount(){
        return $this->totalCount - $this->usedCount;
    }
    
    public function setEnable(){
        $this->isEnabled = true;
    }
    public function setDisable(){
        $this->isEnabled = false;
    }

    public function isEnable(){
        return ($this->isEnabled == true);
    }

    public function coursePriceAfterDiscount(){
        $course = $this->course;        
        if(!$course) throw new DomainException('Invalid course attribute');
        return $course->getPrice() * ((100 - $this->$discountPercentage)/100);
    }

    
    public function givenCoursePriceAfterDiscount(CourseEntity $givenCourse){
        $assignedCourse = $this->course;
        
        if(!$assignedCourse){
            return $givenCourse->getPrice() * ((100 - $this->$discountPercentage)/100);
        }else{
            if($assignedCourse->getId() == $givenCourse->getId()){
                return $assignedCourse->getPrice() * ((100 - $this->$discountPercentage)/100);
            }else{
                return $givenCourse->getPrice();
            }
        }
    }


}
