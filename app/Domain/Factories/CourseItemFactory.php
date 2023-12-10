<?php

namespace App\Domain\Factories;

use Ramsey\Uuid\Uuid;
use App\Domain\Exceptions\MissingArgumentDomainException;
use App\Domain\Exceptions\InvalidArgumentDomainException;

use App\Domain\Factories\CourseFactory;
use App\Domain\Factories\IFactory;
use \DateTime;
use App\Domain\ValueObjects\DateTimeVO;

use App\Domain\AbstractCourseItem as AbstractCourseItemEntity;
use App\Domain\CourseItems\FreeCourseItem as FreeCourseItemEntity;
use App\Domain\CourseItems\PaidCourseItem as PaidCourseItemEntity;


//class CourseItemFactory {
class CourseItemFactory implements IFactory {
    
    public function createObjTree(array $courseItemData) : AbstractCourseItemEntity {         
        if(!isset($courseItemData['cartAddedDate']) && !is_null($courseItemData['cartAddedDate']))
            throw new MissingArgumentDomainException("Missing cartAddedDate parameter for create CourseItem entity");              
        
        if(!isset($courseItemData['isCheckout']))        
            throw new MissingArgumentDomainException("Missing isCheckout parameter for create CourseItem entity"); 

        $method = '';
        if($courseItemData['cartAddedDate'] ==  null){
            if($courseItemData['isCheckout'] == 0){
                $method = 'createFreeCourseItemObjTree';
            }else{
                throw new InvalidArgumentDomainException("Invalid data to create Course Item");             
              
            }
        }else{
            $method = 'createPaidCourseItemObjTree';
        }        

        $courseItemEntity = $this->{$method}($courseItemData);
        return $courseItemEntity;
    }
    
    
    public function createObj(array $courseItemData) : AbstractCourseItemEntity {        
        if(!isset($courseItemData['cartAddedDate']) && !is_null($courseItemData['cartAddedDate']))       
            throw new MissingArgumentDomainException("Missing cartAddedDate parameter for create CourseItem entity");              
        
        if(!isset($courseItemData['isCheckout']))        
            throw new MissingArgumentDomainException("Missing isCheckout parameter for create CourseItem entity"); 

        $method = '';
        if($courseItemData['cartAddedDate'] ==  null){
            if($courseItemData['isCheckout'] == 0){
                $method = 'createFreeCourseItemObj';
            }else{
                throw new InvalidArgumentDomainException("Invalid data to create Course Item");             
            }
        }else{
            $method = 'createPaidCourseItemObj';
        }        

        $courseItemEntity = $this->{$method}($courseItemData);
        return $courseItemEntity;
    }

    
    // ------------> used_coupon_code, usedCouponArr
    // ------------> course_id, courseArr


    private function createPaidCourseItemObjTree(array $courseItemData): PaidCourseItemEntity {
        if(!isset($courseItemData['courseArr']))       
            throw new MissingArgumentDomainException("Missing courseArr parameter for create CourseItem entity");              
                
        /*if(!isset($courseItemData['cartAddedDate']))       
            throw new MissingArgumentDomainException("Missing cartAddedDate parameter for create CourseItem entity");              
        
        if(!isset($courseItemData['isCheckout']))        
            throw new MissingArgumentDomainException("Missing isCheckout parameter for create CourseItem entity");*/              
                
        
        // type validations        
        if(!is_bool($courseItemData['isCheckout']))
            throw new InvalidArgumentDomainException('Invalid isCheckout parameter for CourseItem entity');              
        
        if(!is_array($courseItemData['courseArr']) || empty($courseItemData['courseArr']))    
            throw new InvalidArgumentDomainException("courseArr parameter is not in correct format for create Enrollment entity");  
        
        if( !DateTime::createFromFormat("Y-m-d H:i:s", $courseItemData['cartAddedDate']) &&
            !DateTime::createFromFormat("Y-m-d", $courseItemData['cartAddedDate'])
        ){
            throw new InvalidArgumentDomainException('Invalid cartAddedDate parameter for CourseItem entity'); 
        }

        if ( DateTime::createFromFormat("Y-m-d H:i:s", $courseItemData['cartAddedDate']) )
            $cartAddedDateString    = (new DateTime($courseItemData['cartAddedDate']))->format("Y-m-d");             
                
        if ( DateTime::createFromFormat("Y-m-d", $courseItemData['cartAddedDate']) )
            $cartAddedDateString    = $courseItemData['cartAddedDate'];
        
       
        $courseEntity = (new CourseFactory())->createObjTree($courseItemData['courseArr']);

        $courseItemEntity = new PaidCourseItemEntity(
            $courseEntity,            
            DateTimeVO::createDate(new DateTime($cartAddedDateString)),
            //$courseItemData['cartAddedDate'],            
            $courseItemData['isCheckout']
        );
                
        if (!isset($courseItemData['id']) || $courseItemData['id'] == null) {
            $courseItemData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($courseItemData['uuid'])) {
            $courseItemEntity->setUuid($courseItemData['uuid']);
        }
        
        if (isset($courseItemData['id'])) {
            $courseItemEntity->setId($courseItemData['id']);
        }
        
        $usedCouponArr  = $courseItemData['usedCouponArr'] ?? [];
        if(is_array($usedCouponArr) && !empty($usedCouponArr)){
            $usedCouponEntity = (new CouponFactory())->createObjTree($usedCouponArr);           
            $courseItemEntity->applyCouponCode($usedCouponEntity);
        }

        return $courseItemEntity;
    }

    private function createPaidCourseItemObj(array $courseItemData): PaidCourseItemEntity {
        if(!isset($courseItemData['courseArr']))       
            throw new MissingArgumentDomainException("Missing courseArr parameter for create CourseItem entity");              
                
        /*if(!isset($courseItemData['cartAddedDate']))       
            throw new MissingArgumentDomainException("Missing cartAddedDate parameter for create CourseItem entity");              
        
        if(!isset($courseItemData['isCheckout']))        
            throw new MissingArgumentDomainException("Missing isCheckout parameter for create CourseItem entity");*/              
                
        
        // type validations        
        if(!is_bool($courseItemData['isCheckout']))
            throw new InvalidArgumentDomainException('Invalid isCheckout parameter for CourseItem entity');              
        
        if(!is_array($courseItemData['courseArr']) || empty($courseItemData['courseArr']))    
            throw new InvalidArgumentDomainException("courseArr parameter is not in correct format for create Enrollment entity");  
        
        if( !DateTime::createFromFormat("Y-m-d H:i:s", $courseItemData['cartAddedDate']) &&
            !DateTime::createFromFormat("Y-m-d", $courseItemData['cartAddedDate'])
        ){
            throw new InvalidArgumentDomainException('Invalid cartAddedDate parameter for CourseItem entity'); 
        }

        if ( DateTime::createFromFormat("Y-m-d H:i:s", $courseItemData['cartAddedDate']) )
            $cartAddedDateString    = (new DateTime($courseItemData['cartAddedDate']))->format("Y-m-d");             
                
        if ( DateTime::createFromFormat("Y-m-d", $courseItemData['cartAddedDate']) )
            $cartAddedDateString    = $courseItemData['cartAddedDate'];
        
       
        $courseEntity = (new CourseFactory())->createObjTree($courseItemData['courseArr']);

        $courseItemEntity = new PaidCourseItemEntity(
            $courseEntity,            
            DateTimeVO::createDate(new DateTime($cartAddedDateString)),
            //$courseItemData['cartAddedDate'],            
            $courseItemData['isCheckout']
        );
                
        if (!isset($courseItemData['id']) || $courseItemData['id'] == null) {
            $courseItemData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($courseItemData['uuid'])) {
            $courseItemEntity->setUuid($courseItemData['uuid']);
        }
        
        if (isset($courseItemData['id'])) {
            $courseItemEntity->setId($courseItemData['id']);
        }
        
        return $courseItemEntity;
    }


    private function createFreeCourseItemObjTree(array $courseItemData): FreeCourseItemEntity {
        if(!isset($courseItemData['courseArr']))       
            throw new MissingArgumentDomainException("Missing courseArr parameter for create CourseItem entity");              
                
        if(!is_array($courseItemData['courseArr']) || empty($courseItemData['courseArr']))    
            throw new InvalidArgumentDomainException("courseArr parameter is not in correct format for create Enrollment entity");  
                
        $courseEntity       = (new CourseFactory())->createObjTree($courseItemData['courseArr']);

        $courseItemEntity   = new FreeCourseItemEntity($courseEntity);
                
        if (!isset($courseItemData['id']) || $courseItemData['id'] == null) {
            $courseItemData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($courseItemData['uuid'])) {
            $courseItemEntity->setUuid($courseItemData['uuid']);
        }
        
        if (isset($courseItemData['id'])) {
            $courseItemEntity->setId($courseItemData['id']);
        }
        
        return $courseItemEntity;
    }

    private function createFreeCourseItemObj(array $courseItemData): FreeCourseItemEntity {
        if(!isset($courseItemData['courseArr']))       
            throw new MissingArgumentDomainException("Missing courseArr parameter for create CourseItem entity");              
                
        if(!is_array($courseItemData['courseArr']) || empty($courseItemData['courseArr']))    
            throw new InvalidArgumentDomainException("courseArr parameter is not in correct format for create Enrollment entity");  
                
        $courseEntity       = (new CourseFactory())->createObjTree($courseItemData['courseArr']);

        $courseItemEntity   = new FreeCourseItemEntity($courseEntity);
                
        if (!isset($courseItemData['id']) || $courseItemData['id'] == null) {
            $courseItemData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($courseItemData['uuid'])) {
            $courseItemEntity->setUuid($courseItemData['uuid']);
        }
        
        if (isset($courseItemData['id'])) {
            $courseItemEntity->setId($courseItemData['id']);
        }
        
        return $courseItemEntity;
    }


}