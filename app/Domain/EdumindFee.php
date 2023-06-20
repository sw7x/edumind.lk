<?php


namespace App\Domain;

 

class EdumindFee{
	
	private $id;
	private $uuid;
	private $amount;
    private $date;


    /* associations*/
    protected Enrollment $enrollment;


	// Setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
    public function setDate($date)
    {
        $this->date = $date;
    }

    public function setEnrollment(Enrollment $nrollment)
    {
        $this->enrollment = $enrollment;
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

    public function getAmount()
    {
        return $this->amount;
    }
    public function getDate()
    {
        return $this->date;
    }

    public function getEnrollment()
    {
        return $this->enrollment;
    }


    // toArray method
    public function toArray()
    {
        return [            
            'id' 		=> $this->id,
            'uuid' 		=> $this->uuid,
            'amount'    => $this->amount,
        ];
    }

	
}




// created_at 
// updated_at 
// deleted_at
