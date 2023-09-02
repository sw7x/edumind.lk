<?php

namespace App\Domain\Hydrators;

use App\Domain\CouponCode as CouponCodeEntity;

use Ramsey\Uuid\Uuid;
use App\Domain\Exceptions\InvalidArgumentDomainException;
use App\Domain\Exceptions\MissingArgumentDomainException;
use App\Domain\Hydrators\IHydrator;
use App\Domain\IEntity;
use App\Domain\ValueObjects\PercentageVO;

//class CouponFactory
class CouponHydrator implements IHydrator {

    public static function hydrateData(array $couponData, ?IEntity $couponCodeEntity = null): CouponCodeEntity {
        if(is_null($couponCodeEntity)){
            throw new MissingArgumentDomainException("Missing parameter: CouponCodeEntity is required.");
        }        
        if(!$couponCodeEntity instanceof CouponCodeEntity){
            throw new InvalidArgumentDomainException("provided object must be instance of CouponCodeEntity class");
        }

        if (isset($couponData['uuid']) && $couponCodeEntity->getUuid() === null) {
            $couponCodeEntity->setUuid($couponData['uuid']);
        }        

        if (isset($couponData['beneficiary_commision_percentage_from_discount'])) {
            $couponCodeEntity->setCommisionPercentageFromDiscount(
                new PercentageVO(
                    $couponData['beneficiary_commision_percentage_from_discount']
                )
            );
        }

        if (isset($couponData['total_count'])) {
            $couponCodeEntity->setTotalCount($couponData['total_count']);
        }        

        if (isset($couponData['used_count'])) {
            $couponCodeEntity->setUsedCount($couponData['used_count']);
        }  

        if (isset($couponData['is_enabled'])) {
            $couponCodeEntity->setIsEnabled($couponData['is_enabled']);
        }

        return $couponCodeEntity;
    }


}
