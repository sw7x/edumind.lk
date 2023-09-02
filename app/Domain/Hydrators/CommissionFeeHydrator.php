<?php

namespace App\Domain\Hydrators;

use Ramsey\Uuid\Uuid;
use App\Domain\Exceptions\InvalidArgumentDomainException;
use App\Domain\Exceptions\MissingArgumentDomainException;

use App\Domain\Hydrators\IHydrator;
use App\Domain\IEntity;

class CommissionFeeHydrator implements IHydrator {

    public static function hydrateData(array $commissionFeeData, ?IEntity $commissionFeeEntity = null): CommissionFeeEntity {   
        if(is_null($commissionFeeEntity)){
            throw new MissingArgumentDomainException("Missing parameter: CommissionFeeEntity is required.");
        }

        if(!$commissionFeeEntity instanceof CommissionFeeEntity){
            throw new InvalidArgumentDomainException("provided object must be instance of CommissionFeeEntity class");
        }

        if (!isset($commissionFeeData['id']) || $commissionFeeData['id'] == null) {
            $commissionFeeData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($commissionFeeData['uuid']) && $commissionFeeEntity->getUuid() === null) {
            $commissionFeeEntity->setUuid($commissionFeeData['uuid']);
        }

        if (isset($commissionFeeData['id']) && $commissionFeeEntity->getId() === null) {
            $commissionFeeEntity->setId($commissionFeeData['id']);
        }

        return $commissionFeeEntity;
    }    

}
