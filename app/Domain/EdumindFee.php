<?php


namespace App\Domain;
use App\Domain\Interfaces\IEntity;
use App\Domain\Entity;

use App\Domain\ValueObjects\AmountVO;
use App\Domain\ValueObjects\DateTimeVO;

use App\Domain\Exceptions\AttributeAlreadySetDomainException;

class EdumindFee extends Entity{
	
	private ?int           $id     = null;
	private ?string        $uuid   = null;
	private AmountVO       $amount;
    private ?DateTimeVO    $date   = null;
    
    
    /* associations*/
    /*protected Enrollment $enrollment;*/
    


    public function __construct(AmountVO $amount){
        $this->amount = $amount;
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
    
    public function getDate() : ?DateTimeVO {
        return $this->date;
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

    public function setDate(DateTimeVO $date) : void {
        $this->date = $date;
    }




    


    // toArray method
    public function toArray() : array {
        return [            
            'id' 		=> $this->id,
            'uuid' 		=> $this->uuid,
            'amount'    => $this->amount->getValue(),
            'date'      => $this->date ? $this->date->format() : null
            //'enrollment'=> $this->enrollment ? $this->enrollment->toArray() : null,
        ];
    }

	
}