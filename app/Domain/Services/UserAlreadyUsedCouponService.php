<?php
namespace App\Domain\Services;

use App\Domain\CouponCode as CouponCodeEntity;
use App\Domain\Exceptions\DomainException;
use App\Domain\Services\IDomainService;


class UserAlreadyUsedCouponService implements IDomainService{

	/**
    * @param CouponCode $cc
    * @param PaidEnrollment[] $enrollmentEntityArr
    * @return bool
    */
	public function execute(CouponCodeEntity $cc, array $enrollmentEntityArr) : bool {
        $isUsed = false;
        foreach ($enrollmentEntityArr as $enrollmentEntity) {
        	if($enrollmentEntity->checkGivenCouponUsed($cc)){
				$isUsed = true;
				break;
        	}
        }
        return $isUsed;
    } 
}

