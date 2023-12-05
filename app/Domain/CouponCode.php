<?php


namespace App\Domain;

use App\Domain\Types\CouponCodeTypesEnum;
use App\Domain\Users\User as UserEntity;
use App\Domain\Course as CourseEntity;


use App\Domain\Entity;


use App\Domain\ValueObjects\PercentageVO;
use App\Domain\ValueObjects\AmountVO;

use App\Domain\Exceptions\AttributeAlreadySetDomainException;
use App\Domain\Exceptions\DomainException;



class CouponCode extends Entity
{
    private string          $code;
    private ?string         $uuid        = null;    
    private PercentageVO    $discountPercentage;
    private ?PercentageVO   $commisionPercentageFromDiscount = null;
    private ?int            $totalCount  = null;
    private ?int            $usedCount   = null;
    private ?bool           $isEnabled   = null;
    
    
    /* composition */
    private ?CourseEntity $course;

    /* UserEntity - TeacherUser| MarketerUser */
    private ?UserEntity   $beneficiary = null;




    public function __construct(
        CourseEntity $course = null, 
        String       $code, 
        PercentageVO $discountPercentage
    ){
        $this->course             = $course; 
        $this->code               = $code;   
        $this->discountPercentage = $discountPercentage;    
    }
    

  

    // GETTERS
    public function getCode() : string {
        return $this->code;
    }
    
    public function getUuid() : ?string {
        return $this->uuid;
    }

    public function getDiscountPercentage() : PercentageVO {
        return $this->discountPercentage;
    }

    public function getCommisionPercentageFromDiscount() : ?PercentageVO {
        return $this->commisionPercentageFromDiscount;
    }

    public function getTotalCount() : ?int {
        return $this->totalCount;
    }

    public function getUsedCount() : ?int {
        return $this->usedCount;
    }

    public function getIsEnabled() : ?bool {
        return $this->isEnabled;
    }

    public function getCourse() : ?CourseEntity {
        return $this->course;
    } 

    public function getBeneficiary() : ?UserEntity {
        return $this->beneficiary;
    }


    

    // SETTERS
    final public function setUuid(string $uuid) : void {
        if ($this->uuid !== null) {
            throw new AttributeAlreadySetDomainException('uuid attribute has already been set and cannot be changed.');
        }
        $this->uuid = $uuid;
    }  

    public function setCommisionPercentageFromDiscount(PercentageVO $commisionPercentageFromDiscount) : void {
        $this->commisionPercentageFromDiscount = $commisionPercentageFromDiscount;
    }

    public function setTotalCount(int $totalCount) : void {
        if($totalCount <= 0)
            throw new DomainException("Total Count cannot be zero or less");  

        if(isset($this->usedCount)){
            if ($totalCount < $this->usedCount) {
                throw new DomainException("Invalid total Count for CouponCode Entity");                
            }
        }        

        $this->totalCount = $totalCount;
    }

    public function setUsedCount(int $usedCount) : void {
        if($usedCount < 0)
            throw new DomainException("Used count cannot be negative");

        if(isset($this->totalCount)){
            if ($usedCount > $this->totalCount) {
                throw new DomainException("Invalid used Count for CouponCode Entity");                
            }
        }        

        $this->usedCount = $usedCount;
    }

    public function setIsEnabled(bool $isEnabled) : void {
        $this->isEnabled = $isEnabled;
    }
    
    public function setBeneficiary(UserEntity $beneficiary) : void {
        $this->beneficiary = $beneficiary;
    }



    // toArray method
    public function toArray() : array {
        return [
            'code'                            => $this->code,
            'uuid'                            => $this->uuid,
            'discountPercentage'              => $this->discountPercentage->getValue(),
            'commisionPercentageFromDiscount' => $this->commisionPercentageFromDiscount ? $this->commisionPercentageFromDiscount->getValue() : null,
            'totalCount'                      => $this->totalCount,
            'usedCount'                       => $this->usedCount,
            'isEnabled'                       => $this->isEnabled,
            
            'assignedCourseArr'               => $this->course      ? $this->course->toArray()      : null,
            'assignedCourseId'                => $this->course      ? $this->course->getId()        : null,
            
            'beneficiaryArr'                  => $this->beneficiary ? $this->beneficiary->toArray() : null,
            'beneficiaryId'                   => $this->beneficiary ? $this->beneficiary->getId()   : null
        ];
    }


    

    public function getCouponType() : CouponCodeTypesEnum {
        return $this->course ? 
            CouponCodeTypesEnum::SINGLE_COURSE : 
            CouponCodeTypesEnum::ANY_COURSE;
    }

    public function getAvailableCount() : ?int {
        return ($this->totalCount - $this->usedCount);
    }

    public function increaseUsedCountByOne() : void {
        $this->usedCount = $this->usedCount + 1;
    }
    
    public function setEnable() : void {
        $this->isEnabled = true;
    }
    public function setDisable() : void {
        $this->isEnabled = false;
    }

    public function isEnable() : bool {
        return ($this->isEnabled == true);
    }
    
    /*
    public function discountAmount(){
        $course = $this->course;        
        if(!$course) throw new DomainException('Invalid course attribute');
        return $course->getPrice() * ($this->$discountPercentage)/100);
    }
    */

    public function discountAmountForGivenCourse(CourseEntity $givenCourse) : AmountVO {
        $course = $this->course;        
        
        if($course){
            if($course->getId() != $givenCourse->getId()){
                throw new DomainException('Another course already assigned for this coupon code');} 
        }      

        //return $givenCourse->getPrice() * ($this->discountPercentage/100);
        return $givenCourse->getPrice()->multiply($this->discountPercentage->asFraction());
    }
    
    public function coursePriceAfterDiscount() : AmountVO {
        $course = $this->course;        
        if(!$course) throw new DomainException('specific course was not assigned to the coupon');
        //return $course->getPrice() * ((100 - $this->$discountPercentage)/100);
        return $course->getPrice()->multiply(1 - $this->$discountPercentage->asFraction());
    }

    
    public function givenCoursePriceAfterDiscount(CourseEntity $givenCourse) : AmountVO {
        $assignedCourse = $this->course;
        
        if(!$assignedCourse){
            //return $givenCourse->getPrice() * ((100 - $this->$discountPercentage)/100);
            return $givenCourse->getPrice()->multiply(1 - $this->$discountPercentage->asFraction());            
        }else{
            if($assignedCourse->getId() == $givenCourse->getId()){
                //return $assignedCourse->getPrice() * ((100 - $this->$discountPercentage)/100);
                return $assignedCourse->getPrice()->multiply(1 - $this->$discountPercentage->asFraction());
            }else{
                return $givenCourse->getPrice();
            }
        }
    }

    
    public function edumindPercentageFromDiscount() : ?PercentageVO {
    //public function edumindPercentageFromDiscount() : ?int {
        
        if($this->commisionPercentageFromDiscount == null){
            return null;
        }else{
            //return (100 - $this->commisionPercentageFromDiscount-);
            return new PercentageVO(100 - $this->commisionPercentageFromDiscount->getValue());
        }        
    }


}