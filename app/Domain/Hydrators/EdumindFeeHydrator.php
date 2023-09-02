<?php

namespace App\Domain\Hydrators;

use Ramsey\Uuid\Uuid;

use App\Domain\Exceptions\InvalidArgumentDomainException;
use App\Domain\Exceptions\MissingArgumentDomainException;
use App\Domain\EdumindFee as EdumindFeeEntity;

use App\Domain\Hydrators\IHydrator;
use App\Domain\IEntity;
use App\Domain\ValueObjects\DateTimeVO;
use \DateTime;

class EdumindFeeHydrator implements IHydrator {
    
    public static function hydrateData(array $edumindFeeData, ?IEntity $edumindFeeEntity = null): EdumindFeeEntity {   
        if(is_null($edumindFeeEntity)){
            throw new MissingArgumentDomainException("Missing parameter: EdumindFeeEntity is required.");
        }
        
        if(!$edumindFeeEntity instanceof  EdumindFeeEntity){
            throw new InvalidArgumentDomainException("provided object must be instance of EdumindFeeEntity class");
        }
        
        if (!isset($edumindFeeData['id']) || $edumindFeeData['id'] == null) {
            $edumindFeeData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($edumindFeeData['uuid']) && $edumindFeeEntity->getUuid() === null) {
            $edumindFeeEntity->setUuid($edumindFeeData['uuid']);
        }        

        if (isset($edumindFeeData['id']) && $edumindFeeEntity->getId() === null) {
            $edumindFeeEntity->setId($edumindFeeData['id']);
        }

        if (isset($edumindFeeData['date'])) {
            $edumindFeeEntity->setDate(
                new DateTimeVO(
                    new DateTime($edumindFeeData['date'])    
                )
            );
        }
        
        return $edumindFeeEntity;
    }

}
