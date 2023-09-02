<?php


namespace App\Domain\Hydrators;

use Ramsey\Uuid\Uuid;

use App\Domain\Exceptions\InvalidArgumentDomainException;
use App\Domain\Exceptions\MissingArgumentDomainException;

use App\Domain\Hydrators\IHydrator;
use App\Domain\IEntity;
use \DateTime;

//class CommissionHydrator {
class CommissionHydrator implements IHydrator {
    
    public static function hydrateData(
        array $commissionData, 
        ?IEntity $commissionEntity = null
    ): CommissionEntity {           
        if(is_null($commissionEntity)){
            throw new MissingArgumentDomainException("Missing parameter: commissionEntity is required.");
        }
        
        if(!$commissionEntity instanceof CommissionEntity){
            throw new InvalidArgumentDomainException("provided object must be instance of CommissionEntity class");
        }
        
        if (!isset($commissionData['id']) || $commissionData['id'] == null) {
            $commissionData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }
        
        if (isset($commissionData['uuid']) && $commissionEntity->getUuid() === null) {
            $commissionEntity->setUuid($commissionData['uuid']);
        }   
        
        if (isset($commissionData['id']) && $commissionEntity->getId() === null) {
            $commissionEntity->setId($commissionData['id']);
        }

        /*
        if (isset($commissionData['image'])) {
            $commissionEntity->setImage($commissionData['image']);
        }

        if (isset($commissionData['paid_amount'])) {
            $commissionEntity->setPaidAmount($commissionData['paid_amount']);
        }

        if (isset($commissionData['paid_date'])) {
            $commissionEntity->setPaidDate($commissionData['paid_date']);
        }

        if (isset($commissionData['remarks'])) {
            $commissionEntity->setRemarks($commissionData['remarks']);
        }

        if (isset($commissionData['from_date'])) {
            $commissionEntity->setFromDate($commissionData['from_date']);
        }

        if (isset($commissionData['to_date'])) {
            $commissionEntity->setToDate($commissionData['to_date']);
        }

        if (!empty($fees)) {
            $commissionEntity->setFees($fees);
        }
        */
            
        return $commissionEntity;
    } 


}
