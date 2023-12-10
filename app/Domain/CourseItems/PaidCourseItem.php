<?php

namespace App\Domain\CourseItems;

use App\Domain\AbstractCourseItem as AbstractCourseItemEntity;

use App\Domain\ValueObjects\AmountVO;
use App\Domain\ValueObjects\DateTimeVO;
use App\Domain\Exceptions\InvalidCouponException;
use App\Domain\Types\CourseItemTypesEnum;
use App\Domain\Course as CourseEntity;
use App\Domain\CouponCode as CouponCodeEntity;
use App\Domain\Exceptions\DomainException;


class PaidCourseItem extends AbstractCourseItemEntity{
	
    private DateTimeVO  $cartAddedDate;
    private bool        $isCheckout;
    

    /* associations */
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

        if($course->getPrice()->isEqual(new AmountVO(0))){                                  
            throw new DomainException("Provided course needs to be paid one for PaidCourseItem entity !");}
        
    }


    // Getters
    public function getRevisedPrice() : AmountVO {
        return $this->revisedPrice;
    }

    public function getcartAddedDate() : DateTimeVO {
        return $this->cartAddedDate;
    }
    
    public function getIsCheckout() : bool {
        return $this->isCheckout();
    }
    
    public function getCouponCode() : ?CouponCodeEntity {
        return $this->couponCode;
    }
    
    
    // Setters
    
    
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


    public function markAsCheckout() : void {
        $this->isCheckout = true;
    }

    public function applyCouponCode(CouponCodeEntity $couponCode) : void {
        $canCcApply = $this->canEdumindEarnAfterUsingCoupon($couponCode);        
        if(!$canCcApply)
            throw new InvalidCouponException("Edumind's net amount is zero if the given coupon code is used.");
        
        $ccDiscountPercentage   =   $couponCode->getDiscountPercentage()->asFraction();
        $discountAmount         =   $this->course->getPrice()->multiply($ccDiscountPercentage);
        
        $revisedPrice   =   $this->course->getPrice()->subtract($discountAmount);        
        if($revisedPrice->isLower(new AmountVO(0)))
            throw new DomainException("After applying coupon, revised course price cannot be zero or minus value");
        
        $commisionPercentage    =  $couponCode->getCommisionPercentageFromDiscount();                
        $edumindLoseAmount      =  $discountAmount->multiply(1 + $commisionPercentage->asFraction());
        $beneficiaryEarnAmount  =  $discountAmount->multiply($commisionPercentage->asFraction());
                
        $this->discountAmount        =  $discountAmount;
        $this->revisedPrice          =  $revisedPrice;
        $this->couponCode            =  $couponCode;
        $this->edumindLoseAmount     =  $edumindLoseAmount;
        $this->beneficiaryEarnAmount =  $beneficiaryEarnAmount;
    }
    

    public function removeCouponCode() : void {
        $this->couponCode            = null;    
        $this->discountAmount        = new AmountVO(0);;
        $this->revisedPrice          = $this->course->getPrice();
        $this->edumindLoseAmount     = new AmountVO(0);
        $this->beneficiaryEarnAmount = new AmountVO(0);
    }

    public function type() : CourseItemTypesEnum {
        return $this->isCheckout ? 
            CourseItemTypesEnum::ORDER_ITEM : 
            CourseItemTypesEnum::CART_ITEM;
    }

    public function checkCouponWorksforThis(CouponcodeEntity $givenCc) : bool {
        $ccAssignedCourse   =   $givenCc->getCourse();
        $thisCourseId       =   $this->course->getId();
        
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
    
    
    public function canEdumindEarnAfterUsingCoupon(CouponCodeEntity $couponCode) : bool {       
        try {
            
            $isCouponWorks = $this->checkCouponWorksforThis($couponCode);
            if(!$isCouponWorks)
                throw new InvalidCouponException('Cannot apply provided Coupon code for this course');

        
            $ccDiscountPercentage   =   $couponCode->getDiscountPercentage()->asFraction();
            $commisionPercentage    =   $couponCode->getCommisionPercentageFromDiscount();

            $discountAmount         =   $this->course->getPrice()->multiply($ccDiscountPercentage);

            $edumindLoseAmount      =   $discountAmount->multiply(1 + $commisionPercentage->asFraction());
            
            $edumindNetAmolunt      =   $this->edumindAmount->subtract($edumindLoseAmount);

            $edumindCanEarn         =   $edumindNetAmolunt->isEqual(new AmountVO(0)) ? false : true;
            if(!$edumindCanEarn)
                throw new InvalidCouponException('Edumind have zero net amount when apply provided coupon code to this course');

        } catch (InvalidCouponException $e) {
            $edumindCanEarn         =   false;
        } catch (InvalidArgumentAmountVOException $e) {
            $edumindCanEarn         =   false;
        }
        return $edumindCanEarn;
    }

    public function revisedPrice() : AmountVO {
        return $this->revisedPrice;
    }

    public function checkGivenCouponUsed(CouponCodeEntity $cc) : bool {        
        if(!$this->couponCode)
            return false;
        
        return ($this->couponCode->getCode() == $cc->getCode());
    }


}