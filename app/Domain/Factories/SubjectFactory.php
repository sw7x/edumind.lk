<?php


namespace App\Domain\Factories;

use Ramsey\Uuid\Uuid;

use App\Domain\Subject as SubjectEntity;

use App\Domain\Factories\IFactory;
use App\Domain\Exceptions\MissingArgumentDomainException;
use App\Domain\Exceptions\InvalidArgumentDomainException;
//use App\Domain\IEntity;
use App\Domain\Types\SubjectStatusTypesEnum;



//class SubjectFactory {
class SubjectFactory implements IFactory {
    
    //----------------------> author_id,creatorArr
    public function createObjTree(array $subjectData): SubjectEntity {
        if(!isset($subjectData['name']))       
            throw new MissingArgumentDomainException("Missing name parameter for create Subject entity");              
        
        
        //type validations
        if(!is_string($subjectData['name']) || ($subjectData['name'] === ''))      
            throw new InvalidArgumentDomainException("Invalid name parameter to create Subject entity");             
        
        if (isset($subjectData['status'])) {              
            if (!in_array( 
                            $subjectData['status'], 
                            [SubjectStatusTypesEnum::DRAFT, SubjectStatusTypesEnum::PUBLISHED])) {
                throw new InvalidArgumentDomainException('Invalid status parameter for Subject entity');
            }                
        }

        $subjectEntity = new SubjectEntity($subjectData['name']);
        
        if (!isset($subjectData['id']) || $subjectData['id'] == null) {
            $subjectData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($subjectData['uuid'])) {
            $subjectEntity->setUuid($subjectData['uuid']);
        }        

        if (isset($subjectData['id'])) {
            $subjectEntity->setId($subjectData['id']);
        }

        if (isset($subjectData['description'])) {
            $subjectEntity->setDescription($subjectData['description']);
        }

        if (isset($subjectData['image'])) {
            $subjectEntity->setImage($subjectData['image']);
        }

        if (isset($subjectData['slug'])) {
            $subjectEntity->setSlug($subjectData['slug']);
        }

        if (isset($subjectData['status'])) {              
            $subjectEntity->setStatus($subjectData['status']);      
        }

        if(isset($subjectData['creatorArr']) && is_array($subjectData['creatorArr']) && !empty($subjectData['creatorArr'])){        
            $author = (new UserFactory())->createObjTree($subjectData['creatorArr']);
            $subjectEntity->setAuthor($author);
        }
        return $subjectEntity;
    }


    public function createObj(array $subjectData): SubjectEntity {
        if(!isset($subjectData['name']))       
            throw new MissingArgumentDomainException("Missing name parameter for create Subject entity");              
        

        //type validations
        if(!is_string($subjectData['name']) || ($subjectData['name'] === ''))      
            throw new InvalidArgumentDomainException("Invalid name parameter to create Subject entity");             
        
        if (isset($subjectData['status'])) {              
            if (!in_array( 
                            $subjectData['status'], 
                            [SubjectStatusTypesEnum::DRAFT, SubjectStatusTypesEnum::PUBLISHED])) {
                throw new InvalidArgumentDomainException('Invalid status parameter for Subject entity');
            }                
        }

        $subjectEntity = new SubjectEntity($subjectData['name']);
        
        if (!isset($subjectData['id']) || $subjectData['id'] == null) {
            $subjectData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($subjectData['uuid'])) {
            $subjectEntity->setUuid($subjectData['uuid']);
        }        

        if (isset($subjectData['id'])) {
            $subjectEntity->setId($subjectData['id']);
        }

        if (isset($subjectData['description'])) {
            $subjectEntity->setDescription($subjectData['description']);
        }

        if (isset($subjectData['image'])) {
            $subjectEntity->setImage($subjectData['image']);
        }

        if (isset($subjectData['slug'])) {
            $subjectEntity->setSlug($subjectData['slug']);
        }

        if (isset($subjectData['status'])) {              
            $subjectEntity->setStatus($subjectData['status']);      
        }

        return $subjectEntity;
    }

}
