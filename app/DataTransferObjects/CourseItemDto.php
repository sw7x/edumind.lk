<?php

namespace App\DataTransferObjects;


use App\DataTransferObjects\AbstractDto;

use App\DataTransferObjects\courseDTO;
use App\DataTransferObjects\CouponCodeDTO;



class CourseItemDto extends AbstractDto{

    //public read only
    private courseDTO      $courseDTO;
    private string         $cartAddedDate;
    private bool           $isCheckout;

    private ?int           $id;
    //private ?string        $uuid;
    private ?float         $discountAmount;
    private ?float         $edumindLoseAmount;
    private ?float         $revisedPrice;
    private ?float         $edumindAmount;
    private ?float         $beneficiaryEarnAmount;
    private ?float         $authorAmount;    
    
    private ?CouponCodeDTO $couponCodeDTO;
    

    // Constructor
    public function __construct(
        CourseDTO       $courseDTO,
        string          $cartAddedDate,
        bool            $isCheckout,

        ?int            $id                     = null,
        //?string         $uuid                   = null,        
        ?float          $discountAmount         = 0, 
        ?float          $edumindLoseAmount      = 0,
        ?float          $revisedPrice           = 0, 
        ?float          $edumindAmount          = 0,
        ?float          $beneficiaryEarnAmount  = 0, 
        ?float          $authorAmount           = 0,         
        
        ?CouponCodeDTO  $couponCodeDTO          = null
    ) {        
        $this->courseDTO                        = $courseDTO;
        $this->cartAddedDate                    = $cartAddedDate;
        $this->isCheckout                       = $isCheckout;
        
        $this->id                               = $id;
        //$this->uuid                             = $uuid;
        $this->discountAmount                   = $discountAmount;
        $this->edumindLoseAmount                = $edumindLoseAmount;
        $this->revisedPrice                     = $revisedPrice;
        $this->edumindAmount                    = $edumindAmount;
        $this->beneficiaryEarnAmount            = $beneficiaryEarnAmount;
        $this->authorAmount                     = $authorAmount;

        $this->couponCodeDTO                    = $couponCodeDTO;
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
        return $this->isCheckout();
    }    

    public function getDiscountAmount() : ?float {
        return $this->discountAmount();
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


    public function getCourse() : courseDTO {
        return $this->courseDTO;
    } 

    public function getCouponCode() : ?CouponCodeDTO {
        return $this->couponCodeDTO;
    } 

    public function edumindEarnTotalAmount() : ?float {
        return ($this->edumindAmount - $this->edumindLoseAmount);
    }



    // To Array Method
    public function toArray() : array {
        return [
            'id'                    => $this->id,
            //'uuid'                  => $this->uuid,
            
            'cartAddedDate'         => $this->cartAddedDate,
            //'cartAddedDate'       => $this->cartAddedDate ? $this->cartAddedDate->format('Y-m-d H:i:s') : null,
            
            'isCheckout'            => $this->isCheckout,
            'edumindAmount'         => $this->edumindAmount,
            'authorAmount'          => $this->authorAmount,
            'discountAmount'        => $this->discountAmount,
            'revisedPrice'          => $this->revisedPrice,
            'edumindLoseAmount'     => $this->edumindLoseAmount,
            'beneficiaryEarnAmount' => $this->beneficiaryEarnAmount,

            'courseArr'             => $this->courseDTO->toArray(),
            'courseId'              => $this->courseDTO->getId(),
            
            'usedCouponArr'         => $this->couponCodeDTO ? $this->couponCodeDTO->toArray() : null,
            'usedCouponCode'        => $this->couponCodeDTO ? $this->couponCodeDTO->getCode() : null,
        ];
    }

    
}