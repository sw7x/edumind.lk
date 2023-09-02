<?php

namespace App\Domain\Hydrators;

use Ramsey\Uuid\Uuid;

use App\Domain\ContactUsMessage as ContactUsMessageEntity;
//use App\Domain\Hydrators\UserFactory;
use App\Domain\Exceptions\InvalidArgumentDomainException;
use App\Domain\Exceptions\MissingArgumentDomainException;

use App\Domain\Hydrators\IHydrator;
use App\Domain\IEntity;

class ContactUsHydrator implements IHydrator {

    public static function hydrateData(
        array $contactUsMessageData, 
        ?IEntity $contactUsMessageEntity = null
    ): ContactUsMessageEntity {           
        
        if(is_null($contactUsMessageEntity)){
            throw new MissingArgumentDomainException("Missing parameter: ContactUsMessageEntity is required.");
        }        

        if(!$contactUsMessageEntity instanceof ContactUsMessageEntity){
            throw new InvalidArgumentDomainException("provided object must be instance of ContactUsMessageEntity class");
        }

        if (!isset($contactUsMessageData['id']) || $contactUsMessageData['id'] == null) {
            $contactUsMessageData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($contactUsMessageData['uuid']) && $contactUsMessageEntity->getUuid() === null) {
            $contactUsMessageEntity->setUuid($contactUsMessageData['uuid']);
        }

        if (isset($contactUsMessageData['id']) && $contactUsMessageEntity->getId() === null) {
            $contactUsMessageEntity->setId($contactUsMessageData['id']);
        }

        if (isset($contactUsMessageData['full_name']) && $contactUsMessageEntity->getFullName() === null) {
            $contactUsMessageEntity->setFullName($contactUsMessageData['full_name']);
        }        

        if (isset($contactUsMessageData['email']) && $contactUsMessageEntity->getEmail() === null) {
            $contactUsMessageEntity->setEmail($contactUsMessageData['email']);
        }        

        if (isset($contactUsMessageData['phone']) && $contactUsMessageEntity->getPhone() === null) {
            $contactUsMessageEntity->setPhone($contactUsMessageData['phone']);
        }
        
        return $contactUsMessageEntity;
    }


}
