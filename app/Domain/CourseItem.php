<?php

namespace App\Domain;
use App\Domain\Types\CourseItemTypesEnum;
use App\Domain\Interfaces\IEntity;
use App\Domain\Entity;

use App\Domain\ValueObjects\AmountVO;
use App\Domain\ValueObjects\DateTimeVO;

use App\Domain\Exceptions\AttributeAlreadySetDomainException;


use App\Domain\Course as CourseEntity;
use App\Domain\CouponCode as CouponCodeEntity;
use App\Domain\Exceptions\DomainException;


class CourseItem extends Entity{
	
    private ?int        $id   = null;
    private ?string     $uuid = null;
    private DateTimeVO  $cartAddedDate;
    private bool        $isCheckout;

    private AmountVO    $discountAmount;
    private AmountVO    $edumindLoseAmount;
    private AmountVO    $revisedPrice;
    private AmountVO    $edumindAmount;
    
    private AmountVO    $beneficiaryEarnAmount;
    private AmountVO    $authorAmount;

    
    

    /* associations */
    private CourseEntity        $course;
    private ?CouponCodeEntity   $couponCode = null;




    public function __construct(CourseEntity $course, DateTimeVO $cartAddedDate, bool $isCheckout) {
        $this->course                   =   $course;
        $this->cartAddedDate            =   $cartAddedDate;
        $this->isCheckout               =   $isCheckout;

                        
        $this->edumindAmount            =   $course->getPrice()->multiply(
                                                1 - $course->getAuthorSharePercentage()->asFraction()
                                            );

        $this->authorAmount             =   $course->getPrice()->multiply(
                                                $this->course->getAuthorSharePercentage()->asFraction()
                                            );

        
        $this->discountAmount           =   new AmountVO(0);        
        $this->revisedPrice             =   $course->getPrice();
        $this->edumindLoseAmount        =   new AmountVO(0);
        $this->beneficiaryEarnAmount    =   new AmountVO(0);

        /*
        if($course->getPrice()->isEqual(new AmountVO(0))){                                  
            throw new DomainException("CourseItem entity objects cannot be created using free courses.");}
        */
    }




    

    
    // Getters
    public function getId() : ?int {
        return $this->id;
    }

    public function getUuid() : ?string {
        return $this->uuid;
    }

    public function getRevisedPrice() : AmountVO {
        return $this->revisedPrice;
    }

    public function getBeneficiaryEarnAmount() : AmountVO {
        return $this->beneficiaryEarnAmount;
    }    

    public function getAuthorAmount() : AmountVO {
        return $this->authorAmount;
    }
    
    public function getEdumindAmount() : AmountVO {
        return $this->edumindAmount;
    }
    
    public function getEdumindLooseAmount() : AmountVO {
        return $this->edumindLoseAmount;
    }
    
    public function getcartAddedDate() : DateTimeVO {
        return $this->cartAddedDate;
    }
    
    public function getIsCheckout() : bool {
        return $this->isCheckout();
    }
    
    public function getCourse() : CourseEntity {
        return $this->course;
    }

    public function getCouponCode() : ?CouponCodeEntity {
        return $this->couponCode;
    }
    



    // Setters
    final public function setId(int $id) : void {
        if ($this->id !== null) {
            throw new AttributeAlreadySetDomainException('id attribute already been set and cannot be changed.');
        }
        $this->id  = $id;
    }
        
    final public function setUuid(string $uuid) : void {
        if ($this->uuid !== null) {
            throw new AttributeAlreadySetDomainException('uuid attribute has already been set and cannot be changed.');
        }
        $this->uuid = $uuid;
    }
    



    
    // toArray method
    public function toArray() : array {
        return [
            'id'                    => $this->id,
            'uuid'                  => $this->uuid,
            'cartAddedDate'         => $this->cartAddedDate ? $this->cartAddedDate->format() : null,
            'isCheckout'            => $this->isCheckout,

            'edumindAmount'         => $this->edumindAmount->getValue(),
            'authorAmount'          => $this->authorAmount->getValue(),
            'discountAmount'        => $this->discountAmount->getValue(),
            'revisedPrice'          => $this->revisedPrice->getValue(),
            'edumindLoseAmount'     => $this->edumindLoseAmount->getValue(),
            'beneficiaryEarnAmount' => $this->beneficiaryEarnAmount->getValue(),

            
            'courseArr'             => $this->course->toArray(),
            'courseId'              => $this->course->getId(),
            
            'usedCouponArr'         => $this->couponCode ? $this->couponCode->toArray() : null,
            'usedCouponCode'        => $this->couponCode ? $this->couponCode->getCode() : null
        ];
    }







    public function applyCouponCode(CouponCodeEntity $couponCode) : void {
        $this->couponCode               = $couponCode;
        
        //$this->discountAmount         =   $this->course->getPrice() * $couponCode->getDiscountPercentage()->asFraction();
        $this->discountAmount           =   $this->course->getPrice()->multiply(
                                                $couponCode->getDiscountPercentage()->asFraction()
                                            );
        
        //$this->revisedPrice           = $this->course->getPrice() - $this->discountAmount;
        $revisedPrice                   = $this->course->getPrice()->subtract($this->discountAmount);        
        $this->revisedPrice             = $revisedPrice;
        
        
        $commisionPercentage            = $couponCode->getCommisionPercentageFromDiscount();
        //dump($couponCode);
        //dd($commisionPercentage);
                
        //$this->edumindLoseAmount      = ($this->discountAmount/100) * (100 + $commisionPercentage);
        $this->edumindLoseAmount        = $this->discountAmount->multiply(1 + $commisionPercentage->asFraction());
                
        //$this->beneficiaryEarnAmount  = $this->discountAmount * ($commisionPercentage/100);
        $this->beneficiaryEarnAmount    = $this->discountAmount->multiply($commisionPercentage->asFraction());
        
        if($revisedPrice->isLower(new AmountVO(0)))
            throw new DomainException("After applying coupon, revised course price cannot be zero or minus value");
        
    }
    

    public function removeCouponCode() : void {
        $this->couponCode       = null;    
        $this->discountAmount   = 0;
        $this->revisedPrice     = $this->course->getPrice();
        $this->edumindLoseAmount= 0;
    }

    public function type() : CourseItemTypesEnum {
        return $this->isCheckout ? 
            CourseItemTypesEnum::ORDER_ITEM : 
            CourseItemTypesEnum::CART_ITEM;
    }

    // public function getCourse(){}
    
    public function checkCouponWorksforThis(CouponcodeEntity $givenCc) : bool {
        $ccAssignedCourse   = $givenCc->getCourse();
        $thisCourseId       = $this->course->getId();
        
        if(!$ccAssignedCourse){
            return true;
        }else{
            if($ccAssignedCourse->getId() == $this->course->getId()){
                return true;
            }else{
                return false;
            }
        }
    } 
    
    public function coursePrice() : AmountVO {
        $course = $this->getCourse();
        return new $course->getPrice();       
    }

    public function edumindEarnTotalAmount() : AmountVO {
        //return ($this->edumindAmount - $this->edumindLoseAmount);
        return $this->edumindAmount->subtract($this->edumindLoseAmount);
    }

    public function calcDiscount() : AmountVO {
        return $this->discountAmount;
    }


    public function checkGivenCouponUsed(CouponCodeEntity $cc) : bool {        
        if(!$this->couponCode)
            return false;
        
        return ($this->couponCode->getCode() == $cc->getCode());
    }
    
    public function checkGivenCourse(CourseEntity $givenCourse) : bool {
        return ($givenCourse->getId() == $this->course->getId());
    }  

}