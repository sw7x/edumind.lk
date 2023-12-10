<?php

namespace App\Domain\CourseItems;

use App\Domain\AbstractCourseItem as AbstractCourseItemEntity;
use App\Domain\ValueObjects\AmountVO;
use App\Domain\Course as CourseEntity;
use App\Domain\Exceptions\DomainException;


class FreeCourseItem extends AbstractCourseItemEntity{
	
    public function __construct(CourseEntity $course) {
        $this->course                   =   $course;
                           
        $this->edumindAmount            =   new AmountVO(0);
        $this->authorAmount             =   new AmountVO(0);
        
        $this->discountAmount           =   new AmountVO(0);        
        $this->edumindLoseAmount        =   new AmountVO(0);
        $this->beneficiaryEarnAmount    =   new AmountVO(0);
        
        $this->revisedPrice             =   new AmountVO(0);


        if(!$course->getPrice()->isEqual(new AmountVO(0))){                                  
            throw new DomainException("Provided course needs to be free one for FreeCourseItem entity !");}        

    }
    
    
    //Getters
            
    // Setters
    

    // toArray method
    public function toArray() : array {
        return [
            'id'                    => $this->id,
            'uuid'                  => $this->uuid,
            'cartAddedDate'         => null,
            'isCheckout'            => false,

            'edumindAmount'         => $this->edumindAmount->getValue(),
            'authorAmount'          => $this->authorAmount->getValue(),
            'revisedPrice'          => $this->revisedPrice->getValue(),
            'discountAmount'        => $this->discountAmount->getValue(),
            'edumindLoseAmount'     => $this->edumindLoseAmount->getValue(),
            'beneficiaryEarnAmount' => $this->beneficiaryEarnAmount->getValue(),

            'courseArr'             => $this->course->toArray(),
            'courseId'              => $this->course->getId(),

            'usedCouponArr'         => null,
            'usedCouponCode'        => null
        ];
    }

    
    public function revisedPrice() : AmountVO {
        $course = $this->course;
        return $course->getPrice();
    }

}