<?php

namespace App\Domain\Factories;

use Ramsey\Uuid\Uuid;

use App\Domain\Exceptions\MissingArgumentDomainException;
use App\Domain\Exceptions\InvalidArgumentDomainException;

use App\Domain\EdumindFee as EdumindFeeEntity;
use App\Domain\Factories\IFactory;
//use App\Domain\IEntity;
use App\Domain\ValueObjects\AmountVO;


class EdumindFeeFactory implements IFactory {
    
    public function createObjTree(array $edumindFeeData): EdumindFeeEntity {   
        if(!isset($edumindFeeData['amount']))       
            throw new MissingArgumentDomainException("Missing amount parameter for create EdumindFee entity");              
        
        //type validations
        if(!is_numeric($edumindFeeData['amount']))       
            throw new InvalidArgumentDomainException("Invalid amount parameter to create EdumindFee entity");              
        
        $edumindFeeEntity = new EdumindFeeEntity(
            //$edumindFeeData['amount']
            new AmountVO($edumindFeeData['amount'])
        );        

        /*
        if (!isset($edumindFeeData['id']) || $edumindFeeData['id'] == null) {
            $edumindFeeData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($edumindFeeData['uuid'])) {
            $edumindFeeEntity->setUuid($edumindFeeData['uuid']);
        }
        */        

        if (isset($edumindFeeData['id'])) {
            $edumindFeeEntity->setId($edumindFeeData['id']);
        }

        if (isset($edumindFeeData['date'])) {
            $edumindFeeEntity->setDate($edumindFeeData['date']);
        }
        
        return $edumindFeeEntity;
    }

    public function createObj(array $edumindFeeData): EdumindFeeEntity {   
        if(!isset($edumindFeeData['amount']))      
            throw new MissingArgumentDomainException("Missing amount parameter for create EdumindFee entity");              
                
        //type validations
        if(!is_numeric($edumindFeeData['amount']))       
            throw new InvalidArgumentDomainException("Invalid amount parameter to create EdumindFee entity");              
        
        $edumindFeeEntity = new EdumindFeeEntity(
            //$edumindFeeData['amount']
            new AmountVO($edumindFeeData['amount'])
        );        

        /*
        if (!isset($edumindFeeData['id']) || $edumindFeeData['id'] == null) {
            $edumindFeeData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($edumindFeeData['uuid'])) {
            $edumindFeeEntity->setUuid($edumindFeeData['uuid']);
        }
        */        

        if (isset($edumindFeeData['id'])) {
            $edumindFeeEntity->setId($edumindFeeData['id']);
        }

        if (isset($edumindFeeData['date'])) {
            $edumindFeeEntity->setDate($edumindFeeData['date']);
        }
        
        return $edumindFeeEntity;
    }

}
