<?php
namespace App\Domain\Services;

//use App\Domain\Enrollment;
use App\Domain\CouponCode;

use App\Domain\Exceptions\DomainException;
use App\Domain\Services\IDomainService;
//  this is domanin service



class IsCouponUsedByStudentService implements IDomainService{

	/**
    * @param CouponCode $cc
    * @param Enrollment[] $enrollmentArr
    * @return bool
    */
	public function execute(CouponCode $cc, array $enrollmentArr) : bool {
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

