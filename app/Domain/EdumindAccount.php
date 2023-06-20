<?php


namespace App\Domain;



class EdumindAccount{
	
	
    private $id;
    private $uuid;
    //private $amount;


    /* associations */
    protected $edumindFees = array();


    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    /*
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
    */


    public function setEdumindFees(array $edumindFees)
    {
        $this->edumindFees = $edumindFees;
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

    /*public function getAmount()
    {
        return $this->amount;
    }*/

    public function getAllEdumindFees(){
        return $this->edumindFees;
    }


    // toArray method
    public function toArray()
    {
        return [
            'id'            => $this->id,
            'uuid'          => $this->uuid,
            'edumindFees'   => $this->edumindFees
        ];
    }




    public function getEdumindFeesByTime($fromDate, $toDate){

    }

    public function addEdumindFee(EdumindFee $edumindFee){
        $this->edumindFees[] = $edumindFee;
    }


	
}




