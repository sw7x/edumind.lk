<?php


namespace App\DataTransferObjects;

use App\DataTransferObjects\AbstractDto;

use App\DataTransferObjects\CourseDto;
use App\DataTransferObjects\UserDto;


class CouponCodeDto extends AbstractDto
{
    //public read only
    private ?CourseDto $courseDto;
    private string     $code;
    private float      $discountPercentage;
    
    //private ?string    $uuid;
    private ?float     $commisionPercentageFromDiscount;
    private ?int       $totalCount;
    private ?int       $usedCount;
    private ?bool      $isEnabled;    
    
    private ?UserDto   $beneficiaryDto;


    public function __construct(
        CourseDto $courseDto                       = null, 
        string    $code, 
        float     $discountPercentage, 
        
        //?string   $uuid                            = null, 
        ?float    $commisionPercentageFromDiscount = null,
        ?int      $totalCount                      = null, 
        ?int      $usedCount                       = null, 
        ?bool     $isEnabled                       = null, 

        ?UserDto  $beneficiaryDto                  = null
    ) {
        $this->courseDto                           = $courseDto;
        $this->code                                = $code;
        $this->discountPercentage                  = $discountPercentage;
        
        //$this->uuid                                = $uuid;
        $this->commisionPercentageFromDiscount     = $commisionPercentageFromDiscount;
        
        $this->totalCount                          = $totalCount;
        $this->usedCount                           = $usedCount;
        $this->isEnabled                           = $isEnabled;





        
        $this->beneficiaryDto                      = $beneficiaryDto;
    }
    

    //GETTERS
    /*
    public function getUuid() : ?string {
        return $this->uuid;
    }
    
    public function setBeneficiary(UserEntity $beneficiary){
        $this->beneficiary = $beneficiary;
    }
    */
    
    public function getCode() : string {
        return $this->code;
    }

    public function getDiscountPercentage() : float {
        return $this->discountPercentage;
    }

    public function getCommisionPercentageFromDiscount() : ?float {
        return $this->commisionPercentageFromDiscount;
    }
    
    public function getEdumindPercentageFromDiscount() : ?float {
        return (float)(100 - $this->commisionPercentageFromDiscount);
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

    public function getCourseDto() : ?CourseDto {
        return $this->courseDto;
    }

    public function getBeneficiaryDto() : ?UserDto {
        return $this->beneficiaryDto;
    }

    
    // toArray method
    public function toArray() : array {
        return [
            'code'                              => $this->code,
            //'uuid'                              => $this->uuid,
            'discountPercentage'                => $this->discountPercentage,
            'commisionPercentageFromDiscount'   => $this->commisionPercentageFromDiscount,
            'totalCount'                        => $this->totalCount,
            'usedCount'                         => $this->usedCount,
            'isEnabled'                         => $this->isEnabled,
            
            'assignedCourseArr'                 => $this->courseDto ? $this->courseDto->toArray() : null,
            'assignedCourseId'                  => $this->courseDto ? $this->courseDto->getId() : null,

            'beneficiaryArr'                    => $this->beneficiaryDto ? $this->beneficiaryDto->toArray() : null,
            'beneficiaryId'                     => $this->beneficiaryDto ? $this->beneficiaryDto->getId() : null,

        ];
    }

}