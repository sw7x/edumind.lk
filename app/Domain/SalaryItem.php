<?php


namespace App\Domain;



class SalaryItem{
	
	private $id;
	private $uuid;
	private $image;
	private $paidAmount;
	private $paidDate;
	private $remarks;
	private $fromDate;
	private $toDate;


	// Setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function setPaidAmount($paidAmount)
    {
        $this->paidAmount = $paidAmount;
    }

    public function setPaidDate($paidDate)
    {
        $this->paidDate = $paidDate;
    }

    public function setRemarks($remarks)
    {
        $this->remarks = $remarks;
    }

    public function setFromDate($fromDate)
    {
        $this->fromDate = $fromDate;
    }

    public function setToDate($toDate)
    {
        $this->toDate = $toDate;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getUuid()
    {
        return $this->uuid;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getPaidAmount()
    {
        return $this->paidAmount;
    }

    public function getPaidDate()
    {
        return $this->paidDate;
    }

    public function getRemarks()
    {
        return $this->remarks;
    }

    public function getFromDate()
    {
        return $this->fromDate;
    }

    public function getToDate()
    {
        return $this->toDate;
    }

    // toArray method
    public function toArray()
    {
        return [            
            'id' 		=> $this->id,
            'uuid' 		=> $this->uuid,
            'image' 	=> $this->image,
            'paidAmount'=> $this->paidAmount,
            'paidDate' 	=> $this->paidDate,
            'remarks' 	=> $this->remarks,
            'fromDate' 	=> $this->fromDate,
            'toDate' 	=> $this->toDate,
        ];
    }

	
}




created_at 
updated_at 
deleted_at