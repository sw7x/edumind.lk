<?php

namespace App\DataTransferObjects;


use App\DataTransferObjects\AbstractDto;

use App\DataTransferObjects\courseDto;
use App\DataTransferObjects\CouponCodeDto;



class CourseItemDto extends AbstractDto{

    //public read only
    private courseDto      $courseDto;
    private ?string        $cartAddedDate;
    private bool           $isCheckout;

    private ?int           $id;
    //private ?string      $uuid;
    private ?float         $discountAmount;
    private ?float         $edumindLoseAmount;
    private ?float         $revisedPrice;
    private ?float         $edumindAmount;
    private ?float         $beneficiaryEarnAmount;
    private ?float         $authorAmount;    
    
    private ?CouponCodeDto $couponCodeDto;
    

    // Constructor
    public function __construct(
        CourseDto       $courseDto,
        string          $cartAddedDate          = null,
        bool            $isCheckout,

        ?int            $id                     = null,
        //?string       $uuid                   = null,      
        ?float          $discountAmount         = 0, 
        ?float          $edumindLoseAmount      = 0,
        ?float          $revisedPrice           = 0, 
        ?float          $edumindAmount          = 0,
        ?float          $beneficiaryEarnAmount  = 0, 
        ?float          $authorAmount           = 0,         
        
        ?CouponCodeDto  $couponCodeDto          = null
    ) {        
        $this->courseDto                        = $courseDto;
        $this->cartAddedDate                    = $cartAddedDate;
        $this->isCheckout                       = $isCheckout;
        
        $this->id                               = $id;
        //$this->uuid                           = $uuid;
        $this->discountAmount                   = $discountAmount;
        $this->edumindLoseAmount                = $edumindLoseAmount;
        $this->revisedPrice                     = $revisedPrice;
        $this->edumindAmount                    = $edumindAmount;
        $this->beneficiaryEarnAmount            = $beneficiaryEarnAmount;
        $this->authorAmount                     = $authorAmount;

        $this->couponCodeDto                    = $couponCodeDto;
    }

    


    // Getters
    public function getId(): ?int {
        return $this->id;
    }

    /*public function getUuid() : ?string {
        return $this->uuid;
    }*/
    
    public function getcartAddedDate() : string {
        return $this->cartAddedDate;
    }

    public function getIsCheckout() : bool {
        return $this->isCheckout;
    }    

    public function getDiscountAmount() : ?float {
        return $this->discountAmount;
    }

    public function getEdumindLooseAmount() : ?float {
        return $this->edumindLoseAmount;
    }

    public function getRevisedPrice() : ?float {
        return $this->revisedPrice;
    }    

    public function getEdumindAmount() : ?float {
        return $this->edumindAmount;
    }

    public function getBeneficiaryEarnAmount() : ?float {
        return $this->beneficiaryEarnAmount;
    }    

    public function getAuthorAmount() : ?float {
        return $this->authorAmount;
    }


    public function getCourseDto() : courseDto {
        return $this->courseDto;
    } 

    public function getCouponCodeDto() : ?CouponCodeDto {
        return $this->couponCodeDto;
    } 

    public function edumindNetAmount() : ?float {
        return ($this->edumindAmount - $this->edumindLoseAmount);
    }



    // To Array Method
    public function toArray() : array {
        return [
            'id'                    => $this->id,
            //'uuid'                  => $this->uuid,
            
            'cartAddedDate'         => $this->cartAddedDate ? $this->cartAddedDate : null,            
            'isCheckout'            => $this->isCheckout,
            'edumindAmount'         => $this->edumindAmount,
            'authorAmount'          => $this->authorAmount,
            'discountAmount'        => $this->discountAmount,
            'revisedPrice'          => $this->revisedPrice,
            'edumindLoseAmount'     => $this->edumindLoseAmount,
            'beneficiaryEarnAmount' => $this->beneficiaryEarnAmount,

            'courseArr'             => $this->courseDto->toArray(),
            'courseId'              => $this->courseDto->getId(),
            
            'usedCouponArr'         => $this->couponCodeDto ? $this->couponCodeDto->toArray() : null,
            'usedCouponCode'        => $this->couponCodeDto ? $this->couponCodeDto->getCode() : null,
        ];
    }

    
}