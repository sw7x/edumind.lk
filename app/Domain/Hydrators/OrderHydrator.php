<?php


namespace App\Domain\Hydrators;

use Ramsey\Uuid\Uuid;
use App\Domain\Exceptions\InvalidArgumentDomainException;
use App\Domain\Exceptions\MissingArgumentDomainException;
use App\Domain\Order as OrderEntity;
use App\Domain\Hydrators\IHydrator;
use App\Domain\IEntity;
use App\Domain\ValueObjects\DateTimeVO;
use \DateTime;


//class OrderFactory {
class OrderHydrator implements IHydrator {

    
    public static function hydrateData(array $orderData, ?IEntity $orderEntity = null): OrderEntity {
		
		if(is_null($orderEntity)){
            throw new MissingArgumentDomainException("Missing parameter: OrderEntity is required.");
        }        

        if(!$orderEntity instanceof OrderEntity){
            throw new InvalidArgumentDomainException("provided object must be instance of OrderEntity class");
        }

        if (!isset($orderData['id']) || $orderData['id'] == null) {
			$orderData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
		}

		if (isset($orderData['uuid']) && $orderEntity->getUuid() === null) {
			$orderEntity->setUuid($orderData['uuid']);
		}		

		if (isset($orderData['id']) && $orderEntity->getId() === null) {
			$orderEntity->setId($orderData['id']);
		}

		if (isset($orderData['invoice']['checkout_date'])) {
			$orderEntity->setCheckOutDate(
				new DateTimeVO(
					new DateTime($orderData['invoice']['checkout_date'])
				)    
			);
		}

		if(is_array($orderData['invoice']) && !empty($orderData['invoice'])){            
			$orderEntity->createInvoice($orderData['invoice']);
		}

		return $orderEntity;
	}

}
