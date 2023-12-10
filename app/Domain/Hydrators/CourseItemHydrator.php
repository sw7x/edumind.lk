<?php

namespace App\Domain\Hydrators;

use Ramsey\Uuid\Uuid;
use App\Domain\Exceptions\InvalidArgumentDomainException;
use App\Domain\Exceptions\MissingArgumentDomainException;
use App\Domain\Hydrators\IHydrator;
use App\Domain\IEntity;

use App\Domain\AbstractCourseItem as AbstractCourseItemEntity;
use App\Domain\CourseItems\FreeCourseItem as FreeCourseItemEntity;
use App\Domain\CourseItems\PaidCourseItem as PaidCourseItemEntity;


//class CourseItemFactory {
class CourseItemHydrator implements IHydrator {
    
	
    public static function hydrateData(array $courseItemData, ?IEntity $courseItemEntity = null): AbstractCourseItemEntity {
        if(is_null($courseItemEntity)){
            throw new MissingArgumentDomainException("Missing parameter: Entity is required.");
        }        
        
        if(!$courseItemEntity instanceof AbstractCourseItemEntity){
            throw new InvalidArgumentDomainException("provided object must be instance of AbstractCourseItem class");
        }             

        if (!isset($courseItemData['id']) || $courseItemData['id'] == null) {
            $courseItemData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($courseItemData['uuid']) && $courseItemEntity->getUuid() === null) {
            $courseItemEntity->setUuid($courseItemData['uuid']);
        }
        
        if (isset($courseItemData['id']) && $courseItemEntity->getId() === null) {
            $courseItemEntity->setId($courseItemData['id']);
        }

        return $courseItemEntity;
    }


}