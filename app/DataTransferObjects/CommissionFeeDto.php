<?php

namespace App\DataTransferObjects;

use App\DataTransferObjects\AbstractDto;


class CommissionFeeDto extends AbstractDto{
	
	//public read only 
    private float $amount;
    private ?int  $id;
    

    public function __construct(
        float   $amount, 
        
        ?int    $id    = null
    ) {
        $this->amount  = $amount;
                         
        $this->id      = $id;
    }
    
        
    // GETTERS
    public function getId() : ?int {
        return $this->id;
    }

    public function getAmount() : float {
        return $this->amount;
    }


    // Transformation method
    public function toArray() : array {
        return [
            'amount' => $this->amount,
            'id'     => $this->id,
        ];
    } 
    	
}

//created_at
//updated_at 
//deleted_at 