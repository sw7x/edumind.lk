<?php

namespace App\SharedServices;


use App\Exceptions\CustomException;
use App\Domain\CouponCode as CouponCodeEntity;
use App\Domain\Factories\CouponFactory;
use App\DataTransferObjects\CouponCodeDto;
use App\Mappers\CouponMapper;

class CouponSharedService
{

    public function entityToDbRecArr(CouponCodeEntity $couponEntity) : array {
        $couponEntityArr   = $couponEntity->toArray();
        $payloadArr        = CouponMapper::entityConvertToDbArr($couponEntityArr);
        return $payloadArr;
    }

    public function dtoToDbRecArr(CouponCodeDto $couponDto) : array {
        $couponEntity   = (new CouponFactory())->createObjTree($couponDto->toArray());
        $payloadArr     = $this->entityToDbRecArr($couponEntity);
        return $payloadArr;
    }
}