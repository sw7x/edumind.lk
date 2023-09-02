<?php


namespace App\Domain\Factories;

use Ramsey\Uuid\Uuid;
use App\Domain\Exceptions\MissingArgumentDomainException;
use App\Domain\Exceptions\InvalidArgumentDomainException;
use App\Domain\AuthorSalary as AuthorSalaryEntity;
use App\Domain\Factories\UserFactory;
use App\Domain\Factories\AuthorFeeFactory;
use App\Domain\Factories\IFactory;
//use App\Domain\IEntity;
use \DateTime;
use App\Domain\ValueObjects\DateTimeVO;
use App\Domain\ValueObjects\AmountVO;


class AuthorSalaryFactory implements IFactory {

    // ------------------> authorArr,author_id
    public function createObjTree(array $authorSalaryData): AuthorSalaryEntity {           
        if (!isset($authorSalaryData['paidAmount'])) {
            throw new MissingArgumentDomainException("Missing paidAmount parameter for create AuthorSalary entity");  
        }        
        
        if (!isset($authorSalaryData['image']) && $authorSalaryData['image']) {
            throw new MissingArgumentDomainException("Missing image parameter for create AuthorSalary entity");     
        }        

        if (!isset($authorSalaryData['paidDate'])) {
            throw new MissingArgumentDomainException("Missing paidDate parameter for create AuthorSalary entity");      
        }        

        if (!isset($authorSalaryData['fromDate'])) {
            throw new MissingArgumentDomainException("Missing fromDate parameter for create AuthorSalary entity");      
        }        

        if (!isset($authorSalaryData['toDate'])) {
            throw new MissingArgumentDomainException("Missing toDate parameter for create AuthorSalary entity");      
        }        
        
        if (!isset($authorSalaryData['authorArr'])) {                
            throw new MissingArgumentDomainException("Missing authorArr parameter for create AuthorSalary entity");              
        }

        // type validations 
        if(!is_array($authorSalaryData['authorArr']) || empty($authorSalaryData['authorArr']))    
            throw new InvalidArgumentDomainException("Invalid authorArr parameter to create AuthorSalary entity");
        
        if(!is_numeric($authorSalaryData['paidAmount']))
            throw new InvalidArgumentDomainException("Invalid paidAmount parameter to create AuthorSalary entity");              
        
        if (!DateTime::createFromFormat("Y-m-d", $authorSalaryData['fromDate']))
            throw new InvalidArgumentDomainException("Invalid fromDate parameter to create AuthorSalary entity");
        
        if (!DateTime::createFromFormat("Y-m-d", $authorSalaryData['toDate']))
            throw new InvalidArgumentDomainException("Invalid toDate parameter to create AuthorSalary entity");
                
        if (    !DateTime::createFromFormat("Y-m-d H:i:s", $authorSalaryData['paidDate']) && 
                !DateTime::createFromFormat("Y-m-d", $authorSalaryData['paidDate'])
        ){  throw new InvalidArgumentDomainException("Invalid paidDate parameter to create AuthorSalary entity"); }

        
        if ( DateTime::createFromFormat("Y-m-d H:i:s", $authorSalaryData['paidDate']) )
            $paidDateString     = (new DateTime($authorSalaryData['paidDate']))->format("Y-m-d");
                
        if ( DateTime::createFromFormat("Y-m-d", $authorSalaryData['paidDate']) )
            $paidDateString     = $authorSalaryData['paidDate'];
        

        $authorEntity = (new UserFactory())->createObjTree($authorSalaryData['authorArr']);
        $paidAmount   = new AmountVO($authorSalaryData['paidAmount']);        
        $image        = $authorSalaryData['image'];
        $paidDate     = DateTimeVO::createDate(new DateTime($paidDateString));
        $remarks      = $authorSalaryData['remarks'] ?? '';
        $fromDate     = DateTimeVO::createDate(new DateTime($authorSalaryData['fromDate']));
        $toDate       = DateTimeVO::createDate(new DateTime($authorSalaryData['toDate']));
        
        $feesArr                = $authorSalaryData['fees'] ?? [];
        $authorFeeEntitityArr   = array();
        if (!empty($feesArr)) {            
            foreach ($feesArr as $fee) {
                $authorFeeEntitityArr[] = (new AuthorFeeFactory())->createObjTree($fee);
            }
        }
                   
        $AuthorSalaryEntity   =   new AuthorSalaryEntity(
            $authorEntity,
            $paidAmount,
            $authorFeeEntitityArr,
            $image,
            $paidDate,
            $remarks,
            $fromDate,
            $toDate
        );
    
        if (!isset($authorSalaryData['id']) || $authorSalaryData['id'] == null) {
            $authorSalaryData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }        

        if (isset($authorSalaryData['uuid'])) {
            $AuthorSalaryEntity->setUuid($authorSalaryData['uuid']);
        } 

        if (isset($authorSalaryData['id'])) {
            $AuthorSalaryEntity->setId($authorSalaryData['id']);
        }

        return $AuthorSalaryEntity;
    }





    public function createObj(array $authorSalaryData): AuthorSalaryEntity {           
        if (!isset($authorSalaryData['paidAmount'])) {
            throw new MissingArgumentDomainException("Missing paidAmount parameter for create AuthorSalary entity");  
        }        
        
        if (!isset($authorSalaryData['image']) && $authorSalaryData['image']) {
            throw new MissingArgumentDomainException("Missing image parameter for create AuthorSalary entity");     
        }        

        if (!isset($authorSalaryData['paidDate'])) {
            throw new MissingArgumentDomainException("Missing paidDate parameter for create AuthorSalary entity");      
        }        

        if (!isset($authorSalaryData['fromDate'])) {
            throw new MissingArgumentDomainException("Missing fromDate parameter for create AuthorSalary entity");      
        }        

        if (!isset($authorSalaryData['toDate'])) {
            throw new MissingArgumentDomainException("Missing toDate parameter for create AuthorSalary entity");      
        }        

        if (!isset($authorSalaryData['authorArr'])) {
            throw new MissingArgumentDomainException("Missing authorArr parameter for create AuthorSalary entity");              
        }

        
        // type validations 
         if(!is_array($authorSalaryData['authorArr']) || empty($authorSalaryData['authorArr']))    
            throw new InvalidArgumentDomainException("Invalid authorArr parameter to create AuthorSalary entity");              

        if(!is_numeric($authorSalaryData['paidAmount']))
            throw new InvalidArgumentDomainException("Invalid paidAmount parameter to create AuthorSalary entity");              
        
        if (!DateTime::createFromFormat("Y-m-d", $authorSalaryData['fromDate']))
            throw new InvalidArgumentDomainException("Invalid fromDate parameter to create AuthorSalary entity");
        
        if (!DateTime::createFromFormat("Y-m-d", $authorSalaryData['toDate']))
            throw new InvalidArgumentDomainException("Invalid toDate parameter to create AuthorSalary entity");
        
        if (    !DateTime::createFromFormat("Y-m-d H:i:s", $authorSalaryData['paidDate']) && 
                !DateTime::createFromFormat("Y-m-d", $authorSalaryData['paidDate'])
        ){  throw new InvalidArgumentDomainException("Invalid paidDate parameter to create AuthorSalary entity"); }

        
        if ( DateTime::createFromFormat("Y-m-d H:i:s", $authorSalaryData['paidDate']) )
            $paidDateString     = (new DateTime($authorSalaryData['paidDate']))->format("Y-m-d");
                
        if ( DateTime::createFromFormat("Y-m-d", $authorSalaryData['paidDate']) )
            $paidDateString     = $authorSalaryData['paidDate'];


        $authorEntity = (new UserFactory())->createObj($authorSalaryData['authorArr']);  
        $paidAmount   = new AmountVO($authorSalaryData['paidAmount']);           
        $image        = $authorSalaryData['image'];
        $paidDate     = DateTimeVO::createDate(new DateTime($authorSalaryData['paidDate']));
        $remarks      = $authorSalaryData['remarks'] ?? '';
        $fromDate     = DateTimeVO::createDate(new DateTime($authorSalaryData['fromDate']));
        $toDate       = DateTimeVO::createDate(new DateTime($authorSalaryData['toDate']));

        
        $AuthorSalaryEntity   =   new AuthorSalaryEntity(
            $authorEntity,
            $paidAmount,
            [],
            $image,
            $paidDate,
            $remarks,
            $fromDate,
            $toDate
        );
    
        if (!isset($authorSalaryData['id']) || $authorSalaryData['id'] == null) {
            $authorSalaryData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }        

        if (isset($authorSalaryData['uuid'])) {
            $AuthorSalaryEntity->setUuid($authorSalaryData['uuid']);
        } 

        if (isset($authorSalaryData['id'])) {
            $AuthorSalaryEntity->setId($authorSalaryData['id']);
        }

        return $AuthorSalaryEntity;
    }

}