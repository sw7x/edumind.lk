<?php

namespace App\DataTransferObjects;

use App\DataTransferObjects\AbstractDto;

use App\DataTransferObjects\InvoiceDTO;
use App\DataTransferObjects\UserDTO;



class OrderDto extends AbstractDto
{
        
    //public read only
    private array        $enrollments;
    private UserDTO      $customerDTO;
    
    private ?string      $checkoutDate;
    private ?int         $id;
    //private ?string      $uuid;
    
    private ?InvoiceDTO  $invoiceDTO;


    // Constructor
    public function __construct(        
        array       $enrollments,
        UserDTO     $customerDTO,
        
        string      $checkoutDate = null,
        ?int        $id           = null,
        //?string     $uuid         = null,        
        
        ?InvoiceDTO $invoiceDTO   = null
    ) {
        $this->enrollments        = $enrollments;
        $this->customerDTO        = $customerDTO;

        $this->id                 = $id;
        //$this->uuid               = $uuid;
        $this->checkoutDate       = $checkoutDate;
        
        $this->invoiceDTO         = $invoiceDTO;
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



    public function getCustomer() : UserDTO {
        return $this->customerDTO;
    }    
    public function getEnrollmentDTOs() : array {
        return $this->enrollments;
    }

    public function getInvoice() : ?InvoiceDTO {
        return $this->invoiceDTO;
    }    


    // To Array Method
    public function toArray() : array {
        $enrollmentsArr = [];
        foreach ($this->enrollments as $enrollmentDTO) {
            $enrollmentsArr[] = $enrollmentDTO->toArray();
        }

        return [
            'id'            => $this->id,
            //'uuid'          => $this->uuid,
            'checkoutDate'  => $this->checkoutDate,
            
            'invoiceArr'    => $this->invoiceDTO  ? $this->invoiceDTO->toArray() : null,
            'invoiceId'     => $this->invoiceDTO  ? $this->invoiceDTO->getId() : null,

            'enrollmentsArr'=> $enrollmentsArr,
            
            'studentArr'    => $this->customerDTO->toArray(),
            'studentId'     => $this->customerDTO->getId(),            
            
        ];
    }

}