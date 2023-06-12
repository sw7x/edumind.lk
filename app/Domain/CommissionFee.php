<?php


namespace App\Domain;



class CommissionFee{
	
	private $id;
    private $uuid;
    private $amount;
    


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
    

    // toArray method
    public function toArray()
    {
        return [            
            'id'        => $this->id,
            'uuid'      => $this->uuid,
            'amount'    => $this->amount,
        ];
    }

	
}




//created_at
//updated_at 
//deleted_at 