<?php


namespace App\Domain\Factories;

use Ramsey\Uuid\Uuid;

use App\Domain\Exceptions\MissingArgumentDomainException;
use App\Domain\Exceptions\InvalidArgumentDomainException;


use App\Domain\Commission as CommissionEntity;

use App\Domain\Factories\IFactory;
//use App\Domain\IEntity;
use \DateTime;
use App\Domain\ValueObjects\DateTimeVO;
use App\Domain\ValueObjects\AmountVO;


//class CommissionFactory {
class CommissionFactory implements IFactory {

    
    //--------------------> beneficiary_id, beneficiaryArr
	public function createObjTree(array $commissionData): CommissionEntity {           
        
        if (!isset($commissionData['beneficiaryArr'])) {                
            throw new MissingArgumentDomainException("Missing beneficiaryArr parameter for create Commission entity");              
        }

        if (!isset($commissionData['paidAmount'])) {
            throw new MissingArgumentDomainException("Missing paidAmount parameter for create Commission entity");  
        }        
        
        if (!isset($commissionData['image']) && $commissionData['image']) {
            throw new MissingArgumentDomainException("Missing image parameter for create Commission entity");     
        }        

        if (!isset($commissionData['paidDate'])) {
            throw new MissingArgumentDomainException("Missing paidDate parameter for create Commission entity");      
        }        

        if (!isset($commissionData['fromDate'])) {
            throw new MissingArgumentDomainException("Missing fromDate parameter for create Commission entity");      
        }        

        if (!isset($commissionData['toDate'])) {
            throw new MissingArgumentDomainException("Missing toDate parameter for create Commission entity");      
        }


        // type validations 
        if(!is_array($commissionData['beneficiaryArr']) || empty($commissionData['beneficiaryArr']))    
            throw new InvalidArgumentDomainException("Invalid beneficiaryArr parameter to create Commission entity");              

        if(!is_numeric($commissionData['paidAmount']))
            throw new InvalidArgumentDomainException("Invalid paidAmount parameter to create Commission entity");              
        
        if (!DateTime::createFromFormat("Y-m-d", $commissionData['fromDate']))
            throw new InvalidArgumentDomainException("Invalid fromDate parameter to create Commission entity");
        
        if (!DateTime::createFromFormat("Y-m-d", $commissionData['toDate']))
            throw new InvalidArgumentDomainException("Invalid toDate parameter to create Commission entity");
                
        if (    !DateTime::createFromFormat("Y-m-d H:i:s", $commissionData['paidDate']) && 
                !DateTime::createFromFormat("Y-m-d", $commissionData['paidDate'])
        ){  throw new InvalidArgumentDomainException("Invalid paidDate parameter to create AuthorSalary entity"); }
        
        
        if ( DateTime::createFromFormat("Y-m-d H:i:s", $commissionData['paidDate']) )
            $paidDateString     = (new DateTime($commissionData['paidDate']))->format("Y-m-d");
                
        if ( DateTime::createFromFormat("Y-m-d", $commissionData['paidDate']) )
            $paidDateString     = $commissionData['paidDate'];


        $beneficiary = (new UserFactory())->createObjTree($commissionData['beneficiaryArr']);    
        $paidAmount  = new AmountVO($commissionData['paidAmount']);          
        $image       = $commissionData['image'];
        $paidDate    = DateTimeVO::createDate(new DateTime($paidDateString));
        $remarks     = $commissionData['remarks'] ?? '';
        $fromDate    = DateTimeVO::createDate(new DateTime($commissionData['fromDate']));
        $toDate      = DateTimeVO::createDate(new DateTime($commissionData['toDate']));
        
        $feesArr                = $commissionData['fees'] ?? [];
        $commissionEntitityArr  = array();
        if (!empty($feesArr)) {            
            foreach ($feesArr as $fee) {
                $commissionEntitityArr[] = (new CommissionFeeFactory())->createObjTree($fee);
            }
        }
                   
        $commissionEntity   =   new CommissionEntity(
            $beneficiary,
            $paidAmount,
            $commissionEntitityArr,
            $image,
            $paidDate,
            $remarks,
            $fromDate,
            $toDate
        );
    
        if (!isset($commissionData['id']) || $commissionData['id'] == null) {
            $commissionData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }        

        if (isset($commissionData['uuid'])) {
            $commissionEntity->setUuid($commissionData['uuid']);
        } 

        if (isset($commissionData['id'])) {
            $commissionEntity->setId($commissionData['id']);
        }

        return $commissionEntity;
    }


    public function createObj(array $commissionData): CommissionEntity {           
        
        if (!isset($commissionData['beneficiaryArr'])) {                
            throw new MissingArgumentDomainException("Missing beneficiaryArr parameter for create Commission entity");              
        }

        if (!isset($commissionData['paidAmount'])) {
            throw new MissingArgumentDomainException("Missing paidAmount parameter for create Commission entity");  
        }        
        
        if (!isset($commissionData['image']) && $commissionData['image']) {
            throw new MissingArgumentDomainException("Missing image parameter for create Commission entity");     
        }        

        if (!isset($commissionData['paidDate'])) {
            throw new MissingArgumentDomainException("Missing paidDate parameter for create Commission entity");      
        }        

        if (!isset($commissionData['fromDate'])) {
            throw new MissingArgumentDomainException("Missing fromDate parameter for create Commission entity");      
        }        

        if (!isset($commissionData['toDate'])) {
            throw new MissingArgumentDomainException("Missing toDate parameter for create Commission entity");      
        }


        // type validations 
         if(!is_array($commissionData['beneficiaryArr']) || empty($commissionData['beneficiaryArr']))    
            throw new InvalidArgumentDomainException("Invalid beneficiaryArr parameter to create Commission entity");              

        if(!is_numeric($commissionData['paidAmount']))
            throw new InvalidArgumentDomainException("Invalid paidAmount parameter to create Commission entity");              
        
        if (!DateTime::createFromFormat("Y-m-d", $commissionData['fromDate']))
            throw new InvalidArgumentDomainException("Invalid fromDate parameter to create Commission entity");
        
        if (!DateTime::createFromFormat("Y-m-d", $commissionData['toDate']))
            throw new InvalidArgumentDomainException("Invalid toDate parameter to create Commission entity");
                
        if (    !DateTime::createFromFormat("Y-m-d H:i:s", $commissionData['paidDate']) && 
                !DateTime::createFromFormat("Y-m-d", $commissionData['paidDate'])
        ){  throw new InvalidArgumentDomainException("Invalid paidDate parameter to create AuthorSalary entity"); }
        
        
        if ( DateTime::createFromFormat("Y-m-d H:i:s", $commissionData['paidDate']) )
            $paidDateString     = (new DateTime($commissionData['paidDate']))->format("Y-m-d");
                
        if ( DateTime::createFromFormat("Y-m-d", $commissionData['paidDate']) )
            $paidDateString     = $commissionData['paidDate'];

    
        $beneficiary = (new UserFactory())->createObj($commissionData['beneficiaryArr']);    
        $paidAmount  = new AmountVO($commissionData['paidAmount']);           
        $image       = $commissionData['image'];
        $paidDate    = DateTimeVO::createDate(new DateTime($paidDateString));
        $remarks     = $commissionData['remarks'] ?? '';
        $fromDate    = DateTimeVO::createDate(new DateTime($commissionData['fromDate']));
        $toDate      = DateTimeVO::createDate(new DateTime($commissionData['toDate']));

                   
        $commissionEntity   =   new CommissionEntity(
            $beneficiary,
            $paidAmount,
            [],
            $image,
            $paidDate,
            $remarks,
            $fromDate,
            $toDate
        );
    
        if (!isset($commissionData['id']) || $commissionData['id'] == null) {
            $commissionData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }        

        if (isset($commissionData['uuid'])) {
            $commissionEntity->setUuid($commissionData['uuid']);
        } 

        if (isset($commissionData['id'])) {
            $commissionEntity->setId($commissionData['id']);
        }

        return $commissionEntity;
    }

}
