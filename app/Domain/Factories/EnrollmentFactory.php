<?php

namespace App\Domain\Factories;

use Ramsey\Uuid\Uuid;

use App\Domain\Exceptions\InvalidArgumentDomainException;
use App\Domain\Exceptions\MissingArgumentDomainException;


use App\Domain\Enrollment as EnrollmentEntity;
use App\Domain\Factories\IFactory;
//use App\Domain\IEntity;
use App\Domain\ValueObjects\DateTimeVO;
use \DateTime;




//class EnrollmentFactory {
class EnrollmentFactory implements IFactory {
    

    // -----------------> courseItemArr, course_selection_id
    // -----------------> studentArr, student_id
    public function createObjTree(array $enrollmentData): EnrollmentEntity {   
        if(!isset($enrollmentData['courseItemArr']))
            throw new MissingArgumentDomainException("Missing courseItemArr parameter for create Enrollment entity");    
        
        if(!isset($enrollmentData['studentArr']))       
            throw new MissingArgumentDomainException("Missing studentArr parameter for create Enrollment entity");              
        

        // type validations
        if(isset($enrollmentData['isComplete'])){
            if(!is_bool($enrollmentData['isComplete']))                
                throw new InvalidArgumentDomainException("Invalid isComplete parameter for Enrollment entity");              
        }

        if(isset($enrollmentData['completeDate'])){                 
            if (    !DateTime::createFromFormat("Y-m-d H:i:s", $enrollmentData['completeDate']) && 
                    !DateTime::createFromFormat("Y-m-d", $enrollmentData['completeDate'])
            ){  throw new InvalidArgumentDomainException("Invalid completeDate parameter to create Enrollment entity"); }
        }  



        $courseItemArr  =  $enrollmentData['courseItemArr'];
        $studentArr     =  $enrollmentData['studentArr'];
        //$orderArr     =  $enrollmentData['order'] ?? [];

        if(!is_array($courseItemArr) || empty($courseItemArr)){        
            throw new InvalidArgumentDomainException("courseItemArr parameter is not in correct format for create Enrollment entity");  
        }        

        if(!is_array($studentArr) || empty($studentArr)){        
            throw new InvalidArgumentDomainException("studentArr parameter is not in correct format for create Enrollment entity");
        }
    
        $courseItemEntity   = (new CourseItemFactory())->createObjTree($courseItemArr);
        $studentEntity      = (new UserFactory())->createObjTree($studentArr);
        $enrollmentEntity   = new EnrollmentEntity($courseItemEntity, $studentEntity);
        
        if (!isset($enrollmentData['id']) || $enrollmentData['id'] == null) {
            $enrollmentData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($enrollmentData['uuid'])) {
            $enrollmentEntity->setUuid($enrollmentData['uuid']);
        }

        if (isset($enrollmentData['id'])) {
            $enrollmentEntity->setId($enrollmentData['id']);
        }

        if (isset($enrollmentData['isComplete'])) {
            $enrollmentEntity->setIsComplete($enrollmentData['isComplete']);
        }

        if (isset($enrollmentData['completeDate'])) {
            if ( DateTime::createFromFormat("Y-m-d H:i:s", $enrollmentData['completeDate']) )
                $completeDateString     = (new DateTime($enrollmentData['completeDate']))->format("Y-m-d");
            
            if ( DateTime::createFromFormat("Y-m-d", $enrollmentData['completeDate']) )
                $completeDateString     = $enrollmentData['completeDate'];
            
            $enrollmentEntity->setCompleteDate(
                new DateTimeVO(new DateTime($completeDateString))                
            );
        }

        if (isset($enrollmentData['rating'])) {
            $enrollmentEntity->setRating($enrollmentData['rating']);
        }

        /*
        if(is_array($orderArr) && !empty($orderArr)){        
            $orderEntity = (new OrderFactory())->createObjTree($orderArr);
            $enrollmentEntity->setOrder($orderEntity);
        }
        */
        //dump($enrollmentEntity);
        return $enrollmentEntity;
    }


    public function createObj(array $enrollmentData): EnrollmentEntity {   
        
        if(!isset($enrollmentData['courseItemArr']))       
            throw new MissingArgumentDomainException("Missing courseItemArr parameter for create Enrollment entity");              
        
        if(!isset($enrollmentData['studentArr']))     
            throw new MissingArgumentDomainException("Missing studentArr parameter for create Enrollment entity");              
        

        
        // type validations
        if(isset($enrollmentData['isComplete'])){
            if(!is_bool($enrollmentData['isComplete']))
                throw new InvalidArgumentDomainException("Invalid isComplete parameter for Enrollment entity");              
        }

        if(isset($enrollmentData['completeDate'])){                 
            if (    !DateTime::createFromFormat("Y-m-d H:i:s", $enrollmentData['completeDate']) && 
                    !DateTime::createFromFormat("Y-m-d", $enrollmentData['completeDate'])
            ){  throw new InvalidArgumentDomainException("Invalid completeDate parameter to create Enrollment entity"); }
        }

        $courseItemArr  =  $enrollmentData['courseItemArr'];
        $studentArr     =  $enrollmentData['studentArr'];
        //$orderArr     =  $enrollmentData['order'] ?? [];

        if(!is_array($courseItemArr) || empty($courseItemArr)){        
            throw new InvalidArgumentDomainException("courseItemArr parameter is not in correct format for create Enrollment entity");  
        }        

        if(!is_array($studentArr) || empty($studentArr)){        
            throw new InvalidArgumentDomainException("studentArr parameter is not in correct format for create Enrollment entity");
        }
    
        $courseItemEntity   = (new CourseItemFactory())->createObj($courseItemArr);
        $studentEntity      = (new UserFactory())->createObj($studentArr);
        $enrollmentEntity   = new EnrollmentEntity($courseItemEntity, $studentEntity);

        if (!isset($enrollmentData['id']) || $enrollmentData['id'] == null) {
            $enrollmentData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($enrollmentData['uuid'])) {
            $enrollmentEntity->setUuid($enrollmentData['uuid']);
        }

        if (isset($enrollmentData['id'])) {
            $enrollmentEntity->setId($enrollmentData['id']);
        }

        if (isset($enrollmentData['isComplete'])) {
            $enrollmentEntity->setIsComplete($enrollmentData['isComplete']);
        }

        if (isset($enrollmentData['completeDate'])) {
            if ( DateTime::createFromFormat("Y-m-d H:i:s", $enrollmentData['completeDate']) )
                $completeDateString     = (new DateTime($enrollmentData['completeDate']))->format("Y-m-d");
            
            if ( DateTime::createFromFormat("Y-m-d", $enrollmentData['completeDate']) )
                $completeDateString     = $enrollmentData['completeDate'];
            
            $enrollmentEntity->setCompleteDate(
                new DateTimeVO(new DateTime($completeDateString))                
            );
        }

        if (isset($enrollmentData['rating'])) {
            $enrollmentEntity->setRating($enrollmentData['rating']);
        }

        return $enrollmentEntity;
    }

}
