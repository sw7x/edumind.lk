<?php

namespace App\DataTransferObjects;

use \DateTime;
use App\DataTransferObjects\AbstractDto;



class EdumindFeeDto extends AbstractDto{
	
	//public read only 
    private float       $amount;
    
    private ?int        $id;
    //private ?string   $uuid;
    private ?string     $date;


    public function __construct(
        float   $amount,

        ?int    $id      = null, 
        //?string  $uuid = null,
        ?string $date    = null
    ) {
        $this->amount   = $amount;
        
        $this->id       = $id;
        //$this->uuid   = $uuid,
        $this->date     = $date;                 
    }
    
    

    public function getId() : ?int {
        return $this->id;
    }

    public function getAmount() : float {
        return $this->amount;
    }    

    public function getDate() : ?string {
        return $this->date;
    }


    // Transformation method
    public function toArray() : array {
        return [
            'id'      => $this->id,
            'amount'  => $this->amount,
            'date'    => $this->date,
        ];
    }
    
}


// created_at 
// updated_at 
// deleted_at