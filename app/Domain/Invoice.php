<?php

namespace App\Domain;


class Invoice
{
    private $id;
    private $uuid;
    private $checkoutDate;
    private $billingInfo;
    private $paidAmount;

    // Setters
    public function setId($id){
        $this->id = $id;
    }    

    public function getUuid(){
        return $this->uuid;
    }

    public function setCheckoutDate($checkoutDate){
        $this->checkoutDate = $checkoutDate;
    }

    public function setBillingInfo($billingInfo){
        $this->billingInfo = $billingInfo;
    }

    public function setPaidAmount($paidAmount){
        $this->paidAmount = $paidAmount;
    }

    
    // Getters
    public function getId(){
        return $this->id;
    }
    
    public function setUuid($uuid){
        $this->uuid = $uuid;
    }

    public function getCheckoutDate(){
        return $this->checkoutDate;
    }

    public function getBillingInfo(){
        return $this->billingInfo;
    }    

    public function getPaidAmount(){
        return $this->paidAmount;
    }



    // toArray method
    public function toArray()
    {
        return [
            'id' 			=> $this->id,
            'uuid' 			=> $this->uuid;
            'checkoutDate' 	=> $this->checkoutDate,
            'billingInfo' 	=> $this->billingInfo,
            'paidAmount'    => $this->paidAmount,
        ];
    }
}

//created_at 
//updated_at 
//deleted_at