<?php


namespace App\DataTransferObjects;

use App\DataTransferObjects\AbstractDto;


class AuthorFeeDto extends AbstractDto{
	
	
    //public read only 
    private float   $amount;
    private ?int    $id;

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
            'id'     => $this->id,
            'amount' => $this->amount,
        ];
    }
	
}