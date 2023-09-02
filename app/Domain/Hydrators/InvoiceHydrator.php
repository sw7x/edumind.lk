<?php


namespace App\Domain\Hydrators;

use Ramsey\Uuid\Uuid;

use App\Domain\Invoice as InvoiceEntity;

use App\Domain\Hydrators\IHydrator;
use App\Domain\IEntity;
use App\Domain\ValueObjects\DateTimeVO;
use App\Domain\ValueObjects\AmountVO;
use \DateTime;
use App\Domain\Exceptions\InvalidArgumentDomainException;
use App\Domain\Exceptions\MissingArgumentDomainException;


class InvoiceHydrator implements IHydrator {
    
	public static function hydrateData(array $invoiceData, ?IEntity $invoiceEntity = null): InvoiceEntity {   
        if(is_null($invoiceEntity)){
            throw new MissingArgumentDomainException("Missing parameter: InvoiceEntity is required.");
        }
        
        if(!$invoiceEntity instanceof  InvoiceEntity){
            throw new InvalidArgumentDomainException("provided object must be instance of InvoiceEntity class");
        }

        if (!isset($invoiceData['id']) || $invoiceData['id'] == null) {
            $invoiceData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($invoiceData['uuid']) && $invoiceEntity->getUuid() === null) {
            $invoiceEntity->setUuid($invoiceData['uuid']);
        }        

        if (isset($invoiceData['id']) && $invoiceEntity->getId() === null) {
            $invoiceEntity->setId($invoiceData['id']);
        }

        if (isset($invoiceData['checkout_date'])) {
            $invoiceEntity->setCheckoutDate(
                new DateTimeVO(
                    new DateTime($invoiceData['checkout_date'])
                )
            );
        }

        if (isset($invoiceData['billing_info'])) {
            $invoiceEntity->setBillingInfo($invoiceData['billing_info']);
        }          

        if (isset($invoiceData['paid_amount'])) {
            $invoiceEntity->setPaidAmount(
                new AmountVO($invoiceData['paid_amount'])
            );
        }        

        return $invoiceEntity;
    }


}
