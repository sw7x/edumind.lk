<?php

namespace App\Domain\Factories;

use Ramsey\Uuid\Uuid;

use App\Domain\Course as CourseEntity;


use App\Domain\Factories\UserFactory;
use App\Domain\Factories\SubjectFactory;

use App\Domain\Exceptions\MissingArgumentDomainException;
use App\Domain\Exceptions\InvalidArgumentDomainException;

use App\Domain\Factories\IFactory;

//use App\Domain\Entity;
//use App\Domain\IEntity;

use App\Domain\ValueObjects\PercentageVO;
use App\Domain\ValueObjects\AmountVO;

use App\Domain\Types\CourseStatusTypesEnum;



        


//class CourseFactory
class CourseFactory implements IFactory {

    // -------> creatorArr, teacher_id
    // -------> subjectArr, subject_id   
    public function createObjTree(array $courseData): CourseEntity {
        if(!isset($courseData['name']))       
            throw new MissingArgumentDomainException("Missing name parameter for create Course entity");              
        
        if(!isset($courseData['price']))   
            throw new MissingArgumentDomainException("Missing price parameter for create Course entity");              
        
        
        // type validations                     
        if(!is_string($courseData['name']) || ($courseData['name'] === ''))      
            throw new InvalidArgumentDomainException("Invalid name parameter to create Course entity");             
        
        if(!is_numeric($courseData['price']))     
            throw new InvalidArgumentDomainException("Invalid price parameter to create Course entity");              
        
        if (!in_array( $courseData['status'], [CourseStatusTypesEnum::DRAFT, CourseStatusTypesEnum::PUBLISHED]))
            throw new InvalidArgumentDomainException('Invalid status parameter for Course entity');
                
        if(!is_numeric($courseData['authorSharePercentage']))
            throw new InvalidArgumentDomainException("Invalid authorSharePercentage parameter for Course entity");              
                 
        

        $courseEntity = new CourseEntity(
            $courseData['name'], 
            new AmountVO($courseData['price'])
        );
        
        if (!isset($courseData['id']) || $courseData['id'] == null) {
            $courseData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($courseData['uuid'])) {
            $courseEntity->setUuid($courseData['uuid']);
        }

        if (isset($courseData['id'])) {
            $courseEntity->setId($courseData['id']);
        }
        
        /*
        if (isset($courseData['name'])) {
            $courseEntity->setName($courseData['name']);
        }
        */

        if (isset($courseData['description'])) {
            $courseEntity->setDescription($courseData['description']);
        }

        if (isset($courseData['image'])) {
            $courseEntity->setImage($courseData['image']);
        }

        if (isset($courseData['status'])) {
            $courseEntity->setStatus($courseData['status']);
        }

        if (isset($courseData['headingText'])) {
            $courseEntity->setHeadingText($courseData['headingText']);
        }        

        if (isset($courseData['topics'])) {
            $courseEntity->setTopics($courseData['topics']);
        }        

        if (isset($courseData['content'])) {
            $courseEntity->setContent($courseData['content']);
        }        

        if (isset($courseData['slug'])) {
            $courseEntity->setSlug($courseData['slug']);
        }        

        if (isset($courseData['authorSharePercentage'])) {
            $courseEntity->setAuthorSharePercentage(
                new PercentageVO($courseData['authorSharePercentage'])
            );
        }        

        /*
        if (isset($courseData['price'])) {
            $courseEntity->setPrice($courseData['price']);
        }
        */

        if (isset($courseData['videoCount'])) {
            $courseEntity->setVideoCount($courseData['videoCount']);
        }        

        if (isset($courseData['duration'])) {
            $courseEntity->setDuration($courseData['duration']);
        }

        if(isset($courseData['creatorArr']) && is_array($courseData['creatorArr']) && !empty($courseData['creatorArr'])){        
            $author = (new UserFactory())->createObjTree($courseData['creatorArr']);
            $courseEntity->setAuthor($author);
        }

        if(isset($courseData['subjectArr']) && is_array($courseData['subjectArr']) && !empty($courseData['subjectArr'])){
            $subject = (new SubjectFactory())->createObjTree($courseData['subjectArr']);
            $courseEntity->setSubject($subject);
        }
        return $courseEntity;
    }


    public function createObj(array $courseData): CourseEntity {        
        if(!isset($courseData['name']))
            throw new MissingArgumentDomainException("Missing name parameter for create Course entity");              
        
        if(!isset($courseData['price']))       
            throw new MissingArgumentDomainException("Missing price parameter for create Course entity");              
                

        // type validations 
        if(!is_string($courseData['name']) || ($courseData['name'] === ''))      
            throw new InvalidArgumentDomainException("Invalid name parameter to create Course entity");             
                            
        if(!is_numeric($courseData['price']))     
            throw new InvalidArgumentDomainException("Invalid price parameter to create Course entity");              
        
        if (!in_array( $courseData['status'], [CourseStatusTypesEnum::DRAFT, CourseStatusTypesEnum::PUBLISHED]))
            throw new InvalidArgumentDomainException('Invalid status parameter for Course entity');
                
        if(!is_float($courseData['authorSharePercentage']))
            throw new InvalidArgumentDomainException("Invalid authorSharePercentage parameter for Course entity");

        
        $courseEntity = new CourseEntity(
            $courseData['name'], 
            new AmountVO($courseData['price'])
        );
        
        if (!isset($courseData['id']) || $courseData['id'] == null) {
            $courseData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($courseData['uuid'])) {
            $courseEntity->setUuid($courseData['uuid']);
        }

        if (isset($courseData['id'])) {
            $courseEntity->setId($courseData['id']);
        }
        
        /*
        if (isset($courseData['name'])) {
            $courseEntity->setName($courseData['name']);
        }
        */

        if (isset($courseData['description'])) {
            $courseEntity->setDescription($courseData['description']);
        }

        if (isset($courseData['image'])) {
            $courseEntity->setImage($courseData['image']);
        }

        if (isset($courseData['status'])) {
            $courseEntity->setStatus($courseData['status']);
        }

        if (isset($courseData['headingText'])) {
            $courseEntity->setHeadingText($courseData['headingText']);
        }        

        if (isset($courseData['topics'])) {
            $courseEntity->setTopics($courseData['topics']);
        }        

        if (isset($courseData['content'])) {
            $courseEntity->setContent($courseData['content']);
        }        

        if (isset($courseData['slug'])) {
            $courseEntity->setSlug($courseData['slug']);
        }        

        if (isset($courseData['authorSharePercentage'])) {
            //$courseEntity->setAuthorSharePercentage($courseData['authorSharePercentage']);
            $courseEntity->setAuthorSharePercentage(
                new PercentageVO($courseData['authorSharePercentage'])
            );
        }        

        /*
        if (isset($courseData['price'])) {
            $courseEntity->setPrice($courseData['price']);
        }
        */

        if (isset($courseData['videoCount'])) {
            $courseEntity->setVideoCount($courseData['videoCount']);
        }        

        if (isset($courseData['duration'])) {
            $courseEntity->setDuration($courseData['duration']);
        }
        
        return $courseEntity;
    }
} 