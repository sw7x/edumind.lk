<?php

namespace App\DataTransferObjects;

use App\DataTransferObjects\AbstractDto;




class InvoiceDto extends AbstractDto{
    
    //public read only
    private ?int     $id;
    //private ?string $uuid;
    private ?string  $checkoutDate;
    private ?array   $billingInfo;
    private ?float   $paidAmount;


    public function __construct(
        ?int        $id           = null,
        //?string   $uuid         = null,
        ?string     $checkoutDate = null, 
        ?array      $billingInfo  = null, 
        ?float      $paidAmount   = null
    ) {
        $this->id                 = $id;
        //$this->uuid             = $uuid,
        $this->checkoutDate       = $checkoutDate;
        $this->billingInfo        = $billingInfo;
        $this->paidAmount         = $paidAmount;
    }
    
    
    
    public function getId() : ?int {
        return $this->id;
    }
    
    /*public function getUuid() : ?string {
        return $this->uuid;
    }*/
        
    public function getCheckoutDate() : ?string {
        return $this->checkoutDate;
    }

    public function getBillingInfo() : ?array {
        return $this->billingInfo;
    }    

    public function getPaidAmount() : ?float {
        return $this->paidAmount;
    }

    // toArray method
    public function toArray() : array {
        
        return [
            'id' 			=> $this->id,
            //'uuid' 	    => $this->uuid,
            'checkoutDate' 	=> $this->checkoutDate,
            'billingInfo' 	=> $this->billingInfo,
            'paidAmount'    => $this->paidAmount,
        ];
    }
}

//created_at 
//updated_at 
//deleted_at