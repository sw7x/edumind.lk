<?php


namespace App\Domain\Hydrators;

use Ramsey\Uuid\Uuid;
use App\Domain\Exceptions\InvalidArgumentDomainException;
use App\Domain\Exceptions\MissingArgumentDomainException;

use App\Domain\CourseItem as CourseItemEntity;
//use App\Domain\Hydrators\CourseFactory;
use App\Domain\Hydrators\IHydrator;
use App\Domain\IEntity;


//class CourseItemFactory {
class CourseItemHydrator implements IHydrator {
    
	
    public static function hydrateData(array $courseItemData, ?IEntity $courseItemEntity = null): CourseItemEntity {
        if(is_null($courseItemEntity)){
            throw new MissingArgumentDomainException("Missing parameter: CourseItemEntity is required.");
        }        
        
        if(!$courseItemEntity instanceof  CourseItemEntity){
            throw new InvalidArgumentDomainException("provided object must be instance of CourseItemEntity class");
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