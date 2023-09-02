<?php

namespace App\Domain\Hydrators;

use Ramsey\Uuid\Uuid;
use App\Domain\Exceptions\InvalidArgumentDomainException;
use App\Domain\Exceptions\MissingArgumentDomainException;
use App\Domain\Hydrators\IHydrator;
use App\Domain\IEntity;


class AuthorFeeHydrator implements IHydrator {
    
    public static function hydrateData(
        array $authorFeeData, 
        ?IEntity $authorFeeEntity = null): AuthorFeeEntity {   
        
        if(is_null($authorFeeEntity)){
            throw new MissingArgumentDomainException("Missing parameter: AuthorFeeEntity is required.");
        }
        
        if(!$authorFeeEntity instanceof AuthorFeeEntity){
            throw new InvalidArgumentDomainException("provided object must be instance of AuthorFeeEntity class");
        }

        if (!isset($authorFeeData['id']) || $authorFeeData['id'] == null) {
            $authorFeeData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($authorFeeData['uuid']) && $authorFeeEntity->getUuid() === null) {
            $authorFeeEntity->setUuid($authorFeeData['uuid']);
        }

        if (isset($authorFeeData['id']) && $authorFeeEntity->getId() === null) {
            $authorFeeEntity->setId($authorFeeData['id']);
        }

        return $authorFeeEntity;
    }

}
