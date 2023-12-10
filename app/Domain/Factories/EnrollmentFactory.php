<?php

namespace App\Domain\Factories;

use Ramsey\Uuid\Uuid;
use App\Domain\Exceptions\InvalidArgumentDomainException;
use App\Domain\Exceptions\MissingArgumentDomainException;

use App\Domain\Factories\IFactory;
use App\Domain\ValueObjects\DateTimeVO;
use \DateTime;

use App\Domain\AbstractEnrollment as AbstractEnrollmentEntity;
use App\Domain\Enrollments\FreeEnrollment as FreeEnrollmentEntity;
use App\Domain\Enrollments\PaidEnrollment as PaidEnrollmentEntity;


//class EnrollmentFactory {
class EnrollmentFactory implements IFactory {
    

    public function createObjTree(array $enrollmentData) : AbstractEnrollmentEntity {         
        if(!isset($enrollmentData['courseItemArr']))
            throw new MissingArgumentDomainException("Missing courseItemArr parameter for create Enrollment entity");

        if(!isset($enrollmentData['courseItemArr']['cartAddedDate']) && !is_null($enrollmentData['courseItemArr']['cartAddedDate']))
            throw new MissingArgumentDomainException("Missing cartAddedDate parameter for create CourseItem entity");              
        
        if(!isset($enrollmentData['courseItemArr']['isCheckout']))        
            throw new MissingArgumentDomainException("Missing isCheckout parameter for create CourseItem entity"); 

        $method = '';
        if($enrollmentData['courseItemArr']['cartAddedDate'] ==  null){
            if($enrollmentData['courseItemArr']['isCheckout'] == 0){
                $method = 'createFreeEnrollmentObjTree';
            }else{
                throw new InvalidArgumentDomainException("Invalid data to create Enrollment");             
              
            }
        }else{
            $method = 'createPaidEnrollmentObjTree';
        }        

        $enrollmentEntity = $this->{$method}($enrollmentData);
        return $enrollmentEntity;
    }
    
    
    public function createObj(array $enrollmentData) : AbstractEnrollmentEntity {        
        if(!isset($enrollmentData['courseItemArr']))
            throw new MissingArgumentDomainException("Missing courseItemArr parameter for create Enrollment entity");

        if(!isset($enrollmentData['courseItemArr']['cartAddedDate']) && !is_null($enrollmentData['courseItemArr']['cartAddedDate']))
            throw new MissingArgumentDomainException("Missing cartAddedDate parameter for create CourseItem entity");              
        
        if(!isset($enrollmentData['courseItemArr']['isCheckout']))        
            throw new MissingArgumentDomainException("Missing isCheckout parameter for create CourseItem entity");
    
        $method = '';
        if($enrollmentData['courseItemArr']['cartAddedDate'] ==  null){
            if($enrollmentData['courseItemArr']['isCheckout'] == 0){
                $method = 'createFreeEnrollmentObj';
            }else{
                throw new InvalidArgumentDomainException("Invalid data to create Enrollment");             
            }
        }else{
            $method = 'createPaidEnrollmentObj';
        }        

        $enrollmentEntity = $this->{$method}($enrollmentData);
        return $enrollmentEntity;
    }

    // -----------------> courseItemArr, course_selection_id
    // -----------------> studentArr, student_id
    
    private function createPaidEnrollmentObjTree(array $enrollmentData): PaidEnrollmentEntity {   
        //if(!isset($enrollmentData['courseItemArr']))
            //throw new MissingArgumentDomainException("Missing courseItemArr parameter for create Enrollment entity");    
        
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
        $enrollmentEntity   = new PaidEnrollmentEntity($courseItemEntity, $studentEntity);
        
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

    private function createFreeEnrollmentObjTree(array $enrollmentData): FreeEnrollmentEntity { 
        //if(!isset($enrollmentData['courseItemArr']))       
            //throw new MissingArgumentDomainException("Missing courseItemArr parameter for create Enrollment entity");              
        
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
        $enrollmentEntity   = new FreeEnrollmentEntity($courseItemEntity, $studentEntity);

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


    private function createPaidEnrollmentObj(array $enrollmentData): PaidEnrollmentEntity {   
        //if(!isset($enrollmentData['courseItemArr']))
            //throw new MissingArgumentDomainException("Missing courseItemArr parameter for create Enrollment entity");    
        
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
        $enrollmentEntity   = new PaidEnrollmentEntity($courseItemEntity, $studentEntity);
        
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

    private function createFreeEnrollmentObj(array $enrollmentData): FreeEnrollmentEntity {   
        //if(!isset($enrollmentData['courseItemArr']))       
            //throw new MissingArgumentDomainException("Missing courseItemArr parameter for create Enrollment entity");              
        
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
        $enrollmentEntity   = new FreeEnrollmentEntity($courseItemEntity, $studentEntity);

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