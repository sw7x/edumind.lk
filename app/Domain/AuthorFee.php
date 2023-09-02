<?php


namespace App\Domain;
use App\Domain\Entity;

use App\Domain\ValueObjects\AmountVO;
use App\Domain\Exceptions\AttributeAlreadySetDomainException;

 


class AuthorFee extends Entity{
	
	private  ?int      $id;
	private  ?string   $uuid;
	private  AmountVO  $amount;
	
    public function __construct(
        AmountVO $amount,
        ?int     $id    = null,
        ?string  $uuid  = null
    ){
        $this->amount   = $amount;
        $this->id       = $id; 
        $this->uuid     = $uuid;
    }
    
    
    // Getters
    public function getId() : ?int {
        return $this->id;
    }

    public function getUuid() : ?string {
        return $this->uuid;
    } 
    
    public function getAmount() : AmountVO {
        return $this->amount;
    }
	


    // Setters
    final public function setId(int $id) : void {
        if ($this->id !== null) {
            throw new AttributeAlreadySetDomainException('id attribute already been set and cannot be changed.');
        }
        $this->id  = $id;
    }
        
    final public function setUuid(string $uuid) : void {
        if ($this->uuid !== null) {
            throw new AttributeAlreadySetDomainException('uuid attribute has already been set and cannot be changed.');
        }
        $this->uuid = $uuid;
    }

    

    // toArray method
    public function toArray() : array{
        return [            
            'id' 		=> $this->id,
            'uuid'      => $this->uuid,
            'amount'    => $this->amount ? $this->amount->getValue() : null,

        ];
    }

	
}