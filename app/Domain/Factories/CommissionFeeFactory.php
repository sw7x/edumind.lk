<?php

namespace App\Domain\Factories;

use Ramsey\Uuid\Uuid;

use App\Domain\Exceptions\MissingArgumentDomainException;
use App\Domain\Exceptions\InvalidArgumentDomainException;
use App\Domain\CommissionFee as CommissionFeeEntity;
use App\Domain\Factories\IFactory;
//use App\Domain\IEntity;
use App\Domain\ValueObjects\AmountVO;

class CommissionFeeFactory implements IFactory {

    public function createObjTree(array $commissionFeeData): CommissionFeeEntity {           
        if(!isset($commissionFeeData['amount']))     
            throw new MissingArgumentDomainException("Missing amount parameter for create CommissionFee entity");              
               

        //type validations
        if(!is_numeric($commissionFeeData['amount'])){        
            throw new InvalidArgumentDomainException("Invalid amount parameter to create CommissionFee entity");              
        }

        $commissionFeeEntity = new CommissionFeeEntity(
            new AmountVO($commissionFeeData['amount'])
        );        
        
        /*
        if (!isset($commissionFeeData['id']) || $commissionFeeData['id'] == null) {
            $commissionFeeData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($commissionFeeData['uuid'])) {
            $commissionFeeEntity->setUuid($commissionFeeData['uuid']);
        }
        */

        if (isset($commissionFeeData['id'])) {
            $commissionFeeEntity->setId($commissionFeeData['id']);
        }

        return $commissionFeeEntity;
    }  

    public function createObj(array $commissionFeeData): CommissionFeeEntity {   
        if(!isset($commissionFeeData['amount']))     
            throw new MissingArgumentDomainException("Missing amount parameter for create CommissionFee entity");              
        


        //type validations
        if(!is_numeric($commissionFeeData['amount']))   
            throw new InvalidArgumentDomainException("Invalid amount parameter to create CommissionFee entity");              
        
        $commissionFeeEntity = new CommissionFeeEntity(
            new AmountVO($commissionFeeData['amount'])
        );        

        /*        
        if (!isset($commissionFeeData['id']) || $commissionFeeData['id'] == null) {
            $commissionFeeData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($commissionFeeData['uuid'])) {
            $commissionFeeEntity->setUuid($commissionFeeData['uuid']);
        }
        */

        if (isset($commissionFeeData['id'])) {
            $commissionFeeEntity->setId($commissionFeeData['id']);
        }

        return $commissionFeeEntity;
    }
    
}
