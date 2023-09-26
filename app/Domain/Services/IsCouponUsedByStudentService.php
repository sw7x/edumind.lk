<?php
namespace App\Domain\Services;

use App\Domain\CouponCode as CouponCodeEntity;

use App\Domain\Exceptions\DomainException;
use App\Domain\Services\IDomainService;
//  this is domanin service



class IsCouponUsedByStudentService implements IDomainService{

	/**
    * @param CouponCode $cc
    * @param Enrollment[] $enrollmentArr
    * @return bool
    */
	public function execute(CouponCodeEntity $cc, array $enrollmentArr) : bool {
        $isUsed = false;
        foreach ($enrollmentArr as $enrollment) {
        	if($enrollment->checkGivenCouponUsed($cc)){
				$isUsed = true;
				break;
        	}
        }
        return $isUsed;
    } 
}

