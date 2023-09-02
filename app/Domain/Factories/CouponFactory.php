<?php

namespace App\Domain\Factories;

use App\Domain\CouponCode as CouponCodeEntity;
use Ramsey\Uuid\Uuid;
use App\Domain\Exceptions\MissingArgumentDomainException;
use App\Domain\Exceptions\InvalidArgumentDomainException;
use App\Domain\Factories\CourseFactory;
use App\Domain\Factories\IFactory;
//use App\Domain\IEntity;
use App\Domain\ValueObjects\PercentageVO;

//class CouponFactory
class CouponFactory implements IFactory {

    // --------------> cc_course_id, assignedCourseArr
    // --------------> beneficiaryArr, beneficiary_id
	public function createObjTree(array $couponData): CouponCodeEntity {
        
        $assignedCourseArr      =   $couponData['assignedCourseArr'] ?? [];        
        $assignedCourseEntity   =   (is_array($assignedCourseArr) && !empty($assignedCourseArr)) ? 
                                        (new CourseFactory())->createObjTree($assignedCourseArr) :
                                        null;
            
        if(!isset($couponData['code']))     
            throw new MissingArgumentDomainException("Missing code parameter for create CouponCode entity");              
                
        if(!isset($couponData['discountPercentage']))       
            throw new MissingArgumentDomainException("Missing discountPercentage percentage parameter for create CouponCode entity");              
        

        // type validations
        if(!is_string($couponData['code']) || ($couponData['code'] === ''))      
            throw new InvalidArgumentDomainException("Invalid code parameter to create CouponCode entity");

        if(!is_float($couponData['discountPercentage']))
            throw new InvalidArgumentDomainException("Invalid discountPercentage parameter to create CouponCode entity");              
                
        if(isset($couponData['commisionPercentageFromDiscount'])){
            if(!is_float($couponData['commisionPercentageFromDiscount']))
                throw new InvalidArgumentDomainException("Invalid commisionPercentageFromDiscount parameter for CouponCode entity");              
        }

        if(isset($couponData['totalCount'])){
            if(!is_int($couponData['totalCount']))
                throw new InvalidArgumentDomainException("Invalid totalCount parameter for CouponCode entity");              
        }

        if(isset($couponData['usedCount'])){
            if(!is_int($couponData['usedCount']))
                throw new InvalidArgumentDomainException("Invalid usedCount parameter for CouponCode entity");              
        }

        if(isset($couponData['isEnabled'])){
            if(!is_bool($couponData['isEnabled']))
                throw new InvalidArgumentDomainException("Invalid isEnabled parameter for CouponCode entity");              
        }

        
        $couponCodeEntity = new CouponCodeEntity(
            $assignedCourseEntity,
            $couponData['code'], 
            new PercentageVO($couponData['discountPercentage'])
        );
        
        if (!isset($couponData['code']) || $couponData['code'] == null) {
            $couponData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());            
        }

        
        if (isset($couponData['uuid'])) {
            $couponCodeEntity->setUuid($couponData['uuid']);
        }else{
            //$uuid = str_replace('-', '', Uuid::uuid4()->toString());
            //$couponCodeEntity->setUuid($uuid);
        }        

        /*
        if (isset($couponData['code'])) {
            $couponCodeEntity->setCode($couponData['code']);
        }

        if (isset($couponData['discountPercentage'])) {
            $couponCodeEntity->setDiscountPercentage($couponData['discountPercentage']);
        }
        */

        if (isset($couponData['commisionPercentageFromDiscount'])) {
            $couponCodeEntity->setCommisionPercentageFromDiscount(
                //$couponData['commisionPercentageFromDiscount']
                new PercentageVO(
                    $couponData['commisionPercentageFromDiscount']
                )
            );
        }

        if (isset($couponData['totalCount'])) {
            $couponCodeEntity->setTotalCount($couponData['totalCount']);
        }        

        if (isset($couponData['usedCount'])) {
            $couponCodeEntity->setUsedCount($couponData['usedCount']);
        }  

        if (isset($couponData['isEnabled'])) {
            $couponCodeEntity->setIsEnabled($couponData['isEnabled']);
        }

        $beneficiaryArr = $couponData['beneficiaryArr'] ?? [];
        if(is_array($beneficiaryArr) && !empty($beneficiaryArr)){
            $beneficiaryEntity = (new UserFactory())->createObjTree($beneficiaryArr);           
            $couponCodeEntity->setBeneficiary($beneficiaryEntity);
        }
        return $couponCodeEntity;
    }


    public function createObj(array $couponData): CouponCodeEntity {
        $assignedCourseArr      =   $couponData['assignedCourseArr'] ?? [];        
        $assignedCourseEntity   =   (is_array($assignedCourseArr) && !empty($assignedCourseArr)) ? 
                                        (new CourseFactory())->createObjTree($assignedCourseArr) :
                                        null;

        if(!isset($couponData['code']))    
            throw new MissingArgumentDomainException("Missing coupon code parameter for create coupon code entity");              
        
        if(!isset($couponData['discountPercentage']))        
            throw new MissingArgumentDomainException("Missing discountPercentage parameter for create coupon code entity");              
        


        // type validations 
        if(!is_string($couponData['code']) || ($couponData['code'] === ''))      
            throw new InvalidArgumentDomainException("Invalid code parameter to create CouponCode entity");

        if(!is_float($couponData['discountPercentage']))
            throw new InvalidArgumentDomainException("Invalid discountPercentage parameter to create CouponCode entity");              
                
        if(isset($couponData['beneficiaryCommisionPercentageFromDiscount'])){
            if(!is_float($couponData['beneficiaryCommisionPercentageFromDiscount']))
                throw new InvalidArgumentDomainException("Invalid beneficiaryCommisionPercentageFromDiscount parameter for CouponCode entity");              
        }

        if(isset($couponData['totalCount'])){
            if(!is_int($couponData['totalCount']))
                throw new InvalidArgumentDomainException("Invalid totalCount parameter for CouponCode entity");              
        }

        if(isset($couponData['usedCount'])){
            if(!is_int($couponData['usedCount']))
                throw new InvalidArgumentDomainException("Invalid usedCount parameter for CouponCode entity");              
        }

        if(isset($couponData['isEnabled'])){
            if(!is_bool($couponData['isEnabled']))
                throw new InvalidArgumentDomainException("Invalid isEnabled parameter for CouponCode entity");              
        }


        $couponCodeEntity = new CouponCodeEntity(
            $assignedCourseEntity,
            $couponData['code'], 
            new PercentageVO($couponData['discountPercentage'])
        );
        
        if (!isset($couponData['code']) || $couponData['code'] == null) {
            $couponData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
            
        }

        if (isset($couponData['uuid'])) {
            $couponCodeEntity->setUuid($couponData['uuid']);
        }else{
            //$uuid = str_replace('-', '', Uuid::uuid4()->toString());
            //$couponCodeEntity->setUuid($uuid);
        }

        /*
        if (isset($couponData['code'])) {
            $couponCodeEntity->setCode($couponData['code']);
        }

        if (isset($couponData['discountPercentage'])) {
            $couponCodeEntity->setDiscountPercentage($couponData['discountPercentage']);
        }
        */

        if (isset($couponData['beneficiaryCommisionPercentageFromDiscount'])) {
            $couponCodeEntity->setCommisionPercentageFromDiscount(
                new PercentageVO(
                    $couponData['beneficiaryCommisionPercentageFromDiscount']
                )
            );
        }

        if (isset($couponData['totalCount'])) {
            $couponCodeEntity->setTotalCount($couponData['totalCount']);
        }        

        if (isset($couponData['usedCount'])) {
            $couponCodeEntity->setUsedCount($couponData['usedCount']);
        }  

        if (isset($couponData['isEnabled'])) {
            $couponCodeEntity->setIsEnabled($couponData['isEnabled']);
        }
        
        return $couponCodeEntity;
    }

}
