<?php

namespace App\DataTransferObjects;

use App\DataTransferObjects\AbstractDto;

use App\DataTransferObjects\InvoiceDto;
use App\DataTransferObjects\UserDto;



class OrderDto extends AbstractDto
{
        
    //public read only
    private array        $enrollments;
    private UserDto      $customerDto;
    
    private ?string      $checkoutDate;
    private ?int         $id;
    //private ?string      $uuid;
    
    private ?InvoiceDto  $invoiceDto;


    // Constructor
    public function __construct(        
        array       $enrollments,
        UserDto     $customerDto,
        
        string      $checkoutDate = null,
        ?int        $id           = null,
        //?string     $uuid         = null,        
        
        ?InvoiceDto $invoiceDto   = null
    ) {
        $this->enrollments        = $enrollments;
        $this->customerDto        = $customerDto;

        $this->id                 = $id;
        //$this->uuid               = $uuid;
        $this->checkoutDate       = $checkoutDate;
        
        $this->invoiceDto         = $invoiceDto;
    }


    // Getters
    public function getId() : ?int {
        return $this->id;
    }

    /*public function getUuid() : ?string {
        return $this->uuid;
    } */  

    public function getCheckoutDate() : string {
        return $this->checkoutDate;
    }



    public function getCustomerDto() : UserDto {
        return $this->customerDto;
    }    
    
    public function getEnrollmentDtos() : array {
        return $this->enrollments;
    }

    public function getInvoiceDto() : ?InvoiceDto {
        return $this->invoiceDto;
    }    


    // To Array Method
    public function toArray() : array {
        $enrollmentsArr = [];
        foreach ($this->enrollments as $enrollmentDto) {
            $enrollmentsArr[] = $enrollmentDto->toArray();
        }

        return [
            'id'            => $this->id,
            //'uuid'          => $this->uuid,
            'checkoutDate'  => $this->checkoutDate,
            
            'invoiceArr'    => $this->invoiceDto  ? $this->invoiceDto->toArray() : null,
            'invoiceId'     => $this->invoiceDto  ? $this->invoiceDto->getId() : null,

            'enrollmentsArr'=> $enrollmentsArr,
            
            'studentArr'    => $this->customerDto->toArray(),
            'studentId'     => $this->customerDto->getId(),            
            
        ];
    }

}