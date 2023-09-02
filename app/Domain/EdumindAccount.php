<?php


namespace App\Domain;
use App\Domain\Interfaces\IEntity;
use App\Domain\Entity;

use App\Domain\EdumindFee as EdumindFeeEntity;
use App\Domain\ValueObjects\AmountVO;
use App\Domain\Exceptions\InvalidTypeDomainException;


class EdumindAccount extends Entity{
	
	/* associations */
    /* @var EdumindFeeEntity[] */
    private array $edumindFees;

    

    public function __construct(){
        $this->edumindFees = [];
    }
    
    

    // Getters 
    public function getAllEdumindFees() : array {
        return $this->edumindFees;
    }
    
    
    
    // Setters  
    public function setEdumindFees(array $edumindFees) : void {
        if ($this->edumindFees !== []) {
            throw new AttributeAlreadySetDomainException('edumindFees attribute already been set and cannot be changed.');
        }
        $this->edumindFees = $edumindFees;
    }




    // toArray method
    public function toArray() : array {
        
        /*
        $edumindFeeArr = [];
        foreach ($this->edumindFees as $edumindFee) {
            $edumindFeeArr[] = $edumindFee->toArray();
        }
        */

        return [
            'edumindFees'   => parent::ObjArrConvertToData($this->edumindFees),
        ];
    }




    public function calcSubTotal() : AmountVO {
        $subTotal = new AmountVO(0);        
        foreach ($this->edumindFees as $edumindFee) {
            if (!($edumindFee instanceof EdumindFeeEntity)) {
                throw new InvalidTypeDomainException('Array contains objects that are not EdumindFee Entities.');
            }
            $subTotal->add($edumindFee->getAmount());
        }
        return $subTotal;
    }

    public function getEdumindFeesByTime($fromDate, $toDate) : AmountVO {
    
    }

    public function addEdumindFee(EdumindFeeEntity $edumindFee) : void {
        $this->edumindFees[] = $edumindFee;
    }

}




