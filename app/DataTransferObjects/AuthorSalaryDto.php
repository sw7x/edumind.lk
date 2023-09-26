<?php

namespace App\DataTransferObjects;

use App\DataTransferObjects\AbstractDto;
use App\DataTransferObjects\UserDto;


class AuthorSalaryDto extends AbstractDto{

    //public read only 
    private UserDto $authorDto;

    private ?int    $id;
    //private ?string $uuid;
    private string  $image;
    private float   $paidAmount;
    private string  $paidDate;
    private ?string $remarks;
    private string  $fromDate;
    private string  $toDate;    
    private array   $authorFees;

    public function __construct(
        UserDto $authorDto,
        
        ?int    $id         = null,
        //?string $uuid       = null,
        string  $image      = null,
        float   $paidAmount = null,
        string  $paidDate   = null,
        ?string $remarks    = null,
        string  $fromDate   = null,
        string  $toDate     = null,        
        array   $authorFees = []
    ) {
        $this->authorDto    = $authorDto;

        $this->id           = $id;
        //$this->uuid         = $uuid;
        $this->image        = $image;
        $this->paidAmount   = $paidAmount;
        $this->paidDate     = $paidDate;
        $this->remarks      = $remarks;
        $this->fromDate     = $fromDate;
        $this->toDate       = $toDate;        
        $this->authorFees   = $authorFees;
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
    
    public function getAuthorDto() : UserDto {
        return $this->authorDto;
    }

    public function getAuthorFees() : array {
        return $this->authorFees;
    }




    // toArray method
    public function toArray() : array {
        
        $authorFeeDtoArr = [];
        foreach ($this->authorFees as $authorFeeDto) {
            $authorFeeDtoArr[] = $authorFeeDto->toArray();
        }

        return [            
            'id'        => $this->id,
            //'uuid'      => $this->uuid,
            'image'     => $this->image,
            'paidAmount'=> $this->paidAmount,
            'paidDate'  => $this->paidDate,
            'remarks'   => $this->remarks,
            'fromDate'  => $this->fromDate,
            'toDate'    => $this->toDate,

            'authorArr' => $this->authorDto ? $this->authorDto->toArray() : null,
            'authorId'  => $this->authorDto ? $this->authorDto->getId() : null,
                        
            'fees'   => $authorFeeDtoArr,
        ];
    }

}