<?php


namespace App\DataTransferObjects;

use App\DataTransferObjects\AbstractDto;
use App\DataTransferObjects\UserDTO;

class CommissionDto extends AbstractDto{
    
    //public read only
    private UserDTO $beneficiaryDTO;

    private ?int      $id;
    //private ?string   $uuid;
    private string   $image;
    private float    $paidAmount;
    private string   $paidDate;
    private ?string  $remarks;
    private string   $fromDate;
    private string   $toDate;      
    private array    $commissionFees;

    public function __construct(
        UserDTO $beneficiaryDTO,
        
        ?int    $id             = null,
        //?string $uuid           = null,
        string  $image          = null,
        float   $paidAmount     = null,
        string  $paidDate       = null,
        ?string $remarks        = null,
        string  $fromDate       = null,
        string  $toDate         = null,        
        array   $commissionFees = []
    ) {
        $this->beneficiaryDTO   = $beneficiaryDTO;
        
        $this->id               = $id;
        //$this->uuid             = $uuid;
        $this->image            = $image;
        $this->paidAmount       = $paidAmount;
        $this->paidDate         = $paidDate;
        $this->remarks          = $remarks;
        $this->fromDate         = $fromDate;
        $this->toDate           = $toDate;
        $this->commissionFees   = $commissionFees;
    }

    
    // Getters
    public function getId() : ?int {
        return $this->id;
    }

    /*public function getUuid() : ?string {
        return $this->uuid;
    }*/

    public function getImage() : ?string {
        return $this->image;
    }

    public function getPaidAmount() : ?float {
        return $this->paidAmount;
    }

    public function getPaidDate() : ?string {
        return $this->paidDate;
    }

    public function getRemarks() : ?string {
        return $this->remarks;
    }

    public function getFromDate() : ?string {
        return $this->fromDate;
    }

    public function getToDate() : ?string {
        return $this->toDate;
    }    
    
    public function getBeneficiary() : UserDTO {
        return $this->beneficiaryDTO;
    }
    
    public function getCommissionFees() : array {
        return $this->commissionFees;
    }


    public function toArray() : array {
        
		$commissionFeeDtoArr = [];
        foreach ($this->commissionFees as $commissionFeeDTO) {
            $commissionFeeDtoArr[] = $commissionFeeDTO->toArray();
        }

        return [            
            'id'                => $this->id,
            //'uuid'              => $this->uuid,
            'image'             => $this->image,
            'paidAmount'        => $this->paidAmount,
            'paidDate'          => $this->paidDate,
            'remarks'           => $this->remarks,
            'fromDate'          => $this->fromDate,
            'toDate'            => $this->toDate,
                        
            'beneficiaryArr'    	=> $this->beneficiaryDTO ? $this->beneficiaryDTO->toArray() : null,
            'beneficiaryId'    	    => $this->beneficiaryDTO ? $this->beneficiaryDTO->getId() : null,
            
            'fees'  	            => $commissionFeeDtoArr,
        ];
    }

}

