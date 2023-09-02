<?php


namespace App\Domain\Factories;

use Ramsey\Uuid\Uuid;

use App\Domain\Invoice as InvoiceEntity;

use App\Domain\Factories\IFactory;
//use App\Domain\IEntity;
use App\Domain\ValueObjects\DateTimeVO;
use App\Domain\ValueObjects\AmountVO;
use \DateTime;
use App\Domain\Exceptions\InvalidArgumentDomainException;

class InvoiceFactory implements IFactory {
    
	public function createObjTree(array $invoiceData): InvoiceEntity {   
        
        $invoiceEntity = new InvoiceEntity();        
        

        // type validations
        if (    !DateTime::createFromFormat("Y-m-d H:i:s", $invoiceData['checkoutDate']) &&
                !DateTime::createFromFormat("Y-m-d", $invoiceData['checkoutDate'])
        ){
            throw new InvalidArgumentDomainException("Invalid checkoutDate parameter for Invoice Entity");
        }

        if(!is_numeric($invoiceData['paidAmount']))     
            throw new InvalidArgumentDomainException("Invalid paidAmount parameter for Invoice entity");              

        

        if (!isset($invoiceData['id']) || $invoiceData['id'] == null) {
            $invoiceData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($invoiceData['uuid'])) {
            $invoiceEntity->setUuid($invoiceData['uuid']);
        }        

        if (isset($invoiceData['id'])) {
            $invoiceEntity->setId($invoiceData['id']);
        }

        if (isset($invoiceData['checkoutDate'])) {
            if ( DateTime::createFromFormat("Y-m-d H:i:s", $invoiceData['checkoutDate']) )
                $checkoutDateString     = (new DateTime($invoiceData['checkoutDate']))->format("Y-m-d");

            if ( DateTime::createFromFormat("Y-m-d", $invoiceData['checkoutDate']) )
                $checkoutDateString     = $invoiceData['checkoutDate'];

            $invoiceEntity->setCheckoutDate(
                DateTimeVO::createDate(new DateTime($checkoutDateString))
            );          
        }

        if (isset($invoiceData['billingInfo'])) {
            $invoiceEntity->setBillingInfo($invoiceData['billingInfo']);
        }          

        if (isset($invoiceData['paidAmount'])) {
            $invoiceEntity->setPaidAmount(                
                new AmountVO($invoiceData['paidAmount'])
            );
        }        

        return $invoiceEntity;
    }

    public function createObj(array $invoiceData): InvoiceEntity {   
        
        $invoiceEntity = new InvoiceEntity();        

        
        // type validations
        if (    !DateTime::createFromFormat("Y-m-d H:i:s", $invoiceData['checkoutDate']) &&
                !DateTime::createFromFormat("Y-m-d", $invoiceData['checkoutDate'])
        ){
            throw new InvalidArgumentDomainException("Invalid checkoutDate parameter for Invoice Entity");
        }

        if(!is_numeric($invoiceData['paidAmount']))     
            throw new InvalidArgumentDomainException("Invalid paidAmount parameter for Invoice entity");


        
        if (!isset($invoiceData['id']) || $invoiceData['id'] == null) {
            $invoiceData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($invoiceData['uuid'])) {
            $invoiceEntity->setUuid($invoiceData['uuid']);
        }        

        if (isset($invoiceData['id'])) {
            $invoiceEntity->setId($invoiceData['id']);
        }

        if (isset($invoiceData['checkoutDate'])) {
            if ( DateTime::createFromFormat("Y-m-d H:i:s", $invoiceData['checkoutDate']) )
                $checkoutDateString     = (new DateTime($invoiceData['checkoutDate']))->format("Y-m-d");

            if ( DateTime::createFromFormat("Y-m-d", $invoiceData['checkoutDate']) )
                $checkoutDateString     = $invoiceData['checkoutDate'];

            $invoiceEntity->setCheckoutDate(
                DateTimeVO::createDate(new DateTime($checkoutDateString))
            );          
        }


        if (isset($invoiceData['billingInfo'])) {
            $invoiceEntity->setBillingInfo($invoiceData['billingInfo']);
        }          

        if (isset($invoiceData['paidAmount'])) {
            $invoiceEntity->setPaidAmount(
                new AmountVO($invoiceData['paidAmount'])
            );
        }        

        return $invoiceEntity;
    }

}