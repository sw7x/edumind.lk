<?php

namespace App\Domain\Factories;



use App\Domain\Exceptions\MissingArgumentDomainException;
use App\Domain\Exceptions\InvalidArgumentDomainException;
use App\Domain\AuthorFee as AuthorFeeEntity;
use App\Domain\Factories\IFactory;
//use App\Domain\IEntity;
//use Ramsey\Uuid\Uuid;
use App\Domain\ValueObjects\AmountVO;




class AuthorFeeFactory implements IFactory {
    
    public function createObjTree(array $authorFeeData): AuthorFeeEntity {          
        if(!isset($authorFeeData['amount']))        
            throw new MissingArgumentDomainException("Missing amount parameter for create AuthorFee entity");              
        
        //type validations
        if(!is_numeric($authorFeeData['amount']))       
            throw new InvalidArgumentDomainException("Invalid amount parameter to create AuthorFee entity");              
        

        $authorFeeEntity = new AuthorFeeEntity(
            new AmountVO(
                $authorFeeData['amount']
            )
        );        

        /*
        if (!isset($authorFeeData['id']) || $authorFeeData['id'] == null) {
            $authorFeeData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($authorFeeData['uuid'])) {
            $authorFeeEntity->setUuid($authorFeeData['uuid']);
        }
        */

        if (isset($authorFeeData['id'])) {
            $authorFeeEntity->setId($authorFeeData['id']);
        }

        return $authorFeeEntity;
    }

    public function createObj(array $authorFeeData): AuthorFeeEntity {           
        if(!isset($authorFeeData['amount']))      
            throw new MissingArgumentDomainException("Missing amount parameter for create AuthorFee entity");              
                       

        //type validations
        if(!is_numeric($authorFeeData['amount']))       
            throw new InvalidArgumentDomainException("Invalid amount parameter to create AuthorFee entity");              
        

        $authorFeeEntity = new AuthorFeeEntity(
            new AmountVO(
                $authorFeeData['amount']
            )
        );        

        /*
        if (!isset($authorFeeData['id']) || $authorFeeData['id'] == null) {
            $authorFeeData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($authorFeeData['uuid'])) {
            $authorFeeEntity->setUuid($authorFeeData['uuid']);
        }
        */

        if (isset($authorFeeData['id'])) {
            $authorFeeEntity->setId($authorFeeData['id']);
        }

        return $authorFeeEntity;
    }
}
