<?php

namespace App\DataTransformers\Database;

use App\Domain\CouponCode as CouponCodeEntity;
use App\DataTransferObjects\CouponCodeDto;
use App\DataTransferObjects\Factories\CouponDtoFactory;
use App\Mappers\CouponMapper;
use App\Domain\Factories\CouponFactory;
use App\Repositories\UserRepository;
use App\Repositories\CourseRepository;

class CouponCodeDataTransformer{

	public static function buildDto(array $couponCodeRecData) : CouponCodeDto {

        $couponCodeEntity 	= self::buildEntity($couponCodeRecData);
        $couponCodeDto    	= CouponDtoFactory::fromArray($couponCodeEntity->toArray());
		return $couponCodeDto;
	}

	public static function buildEntity(array $couponCodeRecData) : CouponCodeEntity {

		if(!isset($couponCodeRecData['assigned_course_arr'])){
        	$courseId 							      = $couponCodeRecData['cc_course_id'];
        	$couponCodeRecData['assigned_course_arr'] = is_null($courseId) ? [] : (new CourseRepository())->findDataArrById($courseId);
        }

        if(!isset($couponCodeRecData['beneficiary_arr'])){
        	$beneficiaryId 							= $couponCodeRecData['beneficiary_id'];
        	$couponCodeRecData['beneficiary_arr'] 	= is_null($beneficiaryId) ? [] : (new UserRepository())->findDataArrById($beneficiaryId);
        }

        $couponCodeEntityArr = CouponMapper::dbRecConvertToEntityArr($couponCodeRecData);
        $couponCodeEntity    = (new CouponFactory())->createObjTree($couponCodeEntityArr);
        return $couponCodeEntity;
	}


    public static function entityToDbRecArr(CouponCodeEntity $couponEntity) : array {
        $couponEntityArr   = $couponEntity->toArray();
        $payloadArr        = CouponMapper::entityConvertToDbArr($couponEntityArr);
        return $payloadArr;
    }

    public static function dtoToDbRecArr(CouponCodeDto $couponDto) : array {
        $couponEntity   = (new CouponFactory())->createObjTree($couponDto->toArray());
        $payloadArr     = self::entityToDbRecArr($couponEntity);
        return $payloadArr;
    }


}




/*
$rr = (new CouponRepository())->findDataArrByCode('1EHW75');
dump($rr);
dump(CouponCodeDataTransformer::buildDto($rr));
dump(CouponCodeDataTransformer::buildEntity($rr));
dump('-----------------------');

$user11 = Coupon::find('1EHW75');
dump($user11);
dump($user11->toArray());
dump(CouponCodeDataTransformer::buildDto($rr));
dump(CouponCodeDataTransformer::buildEntity($rr));

dd('k');


*/


