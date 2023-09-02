<?php


namespace App\DataTransferObjects;

use App\DataTransferObjects\AbstractDto;

use App\DataTransferObjects\CourseDTO;
use App\DataTransferObjects\UserDTO;


class CouponCodeDto extends AbstractDto
{
    //public read only
    private ?CourseDTO $courseDTO;
    private string     $code;
    private float      $discountPercentage;
    
    //private ?string    $uuid;
    private ?float     $commisionPercentageFromDiscount;
    private ?int       $totalCount;
    private ?int       $usedCount;
    private ?bool      $isEnabled;    
    
    private ?UserDTO   $beneficiaryDTO;


    public function __construct(
        CourseDTO $courseDTO                       = null, 
        string    $code, 
        float     $discountPercentage, 
        
        //?string   $uuid                            = null, 
        ?float    $commisionPercentageFromDiscount = null,
        ?int      $totalCount                      = null, 
        ?int      $usedCount                       = null, 
        ?bool     $isEnabled                       = null, 

        ?UserDTO  $beneficiaryDTO                  = null
    ) {
        $this->courseDTO                           = $courseDTO;
        $this->code                                = $code;
        $this->discountPercentage                  = $discountPercentage;
        
        //$this->uuid                                = $uuid;
        $this->commisionPercentageFromDiscount     = $commisionPercentageFromDiscount;
        
        $this->totalCount                          = $totalCount;
        $this->usedCount                           = $usedCount;
        $this->isEnabled                           = $isEnabled;





        
        $this->beneficiaryDTO                      = $beneficiaryDTO;
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

    public function getTotalCount() : ?int {
        return $this->totalCount;
    }

    public function getUsedCount() : ?int {
        return $this->usedCount;
    }

    public function getIsEnabled() : ?bool {
        return $this->isEnabled;
    }

    public function getCourseDTO() : ?CourseDTO {
        return $this->courseDTO;
    }

    public function getBeneficiaryDTO() : ?UserDTO {
        return $this->beneficiaryDTO;
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
            
            'assignedCourseArr'                 => $this->courseDTO ? $this->courseDTO->toArray() : null,
            'assignedCourseId'                  => $this->courseDTO ? $this->courseDTO->getId() : null,

            'beneficiaryArr'                    => $this->beneficiaryDTO ? $this->beneficiaryDTO->toArray() : null,
            'beneficiaryId'                     => $this->beneficiaryDTO ? $this->beneficiaryDTO->getId() : null,

        ];
    }

}