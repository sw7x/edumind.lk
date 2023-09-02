<?php


namespace App\Domain\Hydrators;

use Ramsey\Uuid\Uuid;

use App\Domain\Exceptions\InvalidArgumentDomainException;
use App\Domain\Exceptions\MissingArgumentDomainException;

use App\Domain\AuthorSalary as AuthorSalaryEntity;
use App\Domain\Users\TeacherUser as TeacherUserEntity;

use App\Domain\Hydrators\UserFactory;
use App\Domain\Hydrators\AuthorFeeFactory;


use App\Domain\Hydrators\IHydrator;
use App\Domain\IEntity;



class AuthorSalaryHydrator implements IHydrator {

    public static function hydrateData(
        array $authorSalaryData, 
        ?IEntity $authorSalaryEntity = null
    ): AuthorSalaryEntity {           
        
        if(is_null($authorSalaryEntity)){
            throw new MissingArgumentDomainException("Missing parameter: AuthorSalaryEntity is required.");
        }
        
        if(!$authorSalaryEntity instanceof AuthorSalaryEntity){
            throw new InvalidArgumentDomainException("provided object must be instance of AuthorSalaryEntity class");
        }
        
        if (!isset($authorSalaryData['id']) || $authorSalaryData['id'] == null) {
            $authorSalaryData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }
        
        if (isset($authorSalaryData['uuid']) && $authorSalaryEntity->getUuid() === null) {
            $authorSalaryEntity->setUuid($authorSalaryData['uuid']);
        }   
        
        if (isset($authorSalaryData['id']) && $authorSalaryEntity->getId() === null) {
            $AuthorSalaryEntity->setId($authorSalaryData['id']);
        }

        return $AuthorSalaryEntity;
    }

}