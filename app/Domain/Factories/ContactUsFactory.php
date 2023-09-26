<?php

namespace App\Domain\Factories;

use Ramsey\Uuid\Uuid;

use App\Domain\ContactUsMessage as ContactUsMessageEntity;
use App\Domain\Factories\UserFactory;
use App\Domain\Exceptions\MissingArgumentDomainException;
use App\Domain\Exceptions\InvalidArgumentDomainException;
use App\Domain\Factories\IFactory;
//use App\Domain\IEntity;

use \DateTime;
use App\Domain\ValueObjects\DateTimeVO;

class ContactUsFactory implements IFactory {

    //--------------> userArr, user_id
    public function createObjTree(array $contactUsMessageData): ContactUsMessageEntity {           
        if(!isset($contactUsMessageData['message']))      
            throw new MissingArgumentDomainException("Missing message parameter for create ContactUsMessage entity");              
        
        if(!isset($contactUsMessageData['subject']))      
            throw new MissingArgumentDomainException("Missing subject parameter for create ContactUsMessage entity");              
                              

        //type validations
        if(!is_string($contactUsMessageData['message']) || ($contactUsMessageData['message'] === ''))      
            throw new InvalidArgumentDomainException("Invalid message parameter to create ContactUsMessage entity");

        if(!is_string($contactUsMessageData['subject']) || ($contactUsMessageData['subject'] === ''))      
            throw new InvalidArgumentDomainException("Invalid subject parameter to create ContactUsMessage entity");

        if(isset($contactUsMessageData['email'])){
            if(!filter_var($contactUsMessageData['email'], FILTER_VALIDATE_EMAIL)) 
                throw new InvalidArgumentDomainException("Invalid email parameter for ContactUsMessage entity");             
        }

        
        $contactUsMessageEntity = new ContactUsMessageEntity(
            $contactUsMessageData['message'],
            $contactUsMessageData['subject']
        );
       
        if (!isset($contactUsMessageData['id']) || $contactUsMessageData['id'] == null) {
            $contactUsMessageData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($contactUsMessageData['uuid'])) {
            $contactUsMessageEntity->setUuid($contactUsMessageData['uuid']);
        }

        if (isset($contactUsMessageData['id'])) {
            $contactUsMessageEntity->setId($contactUsMessageData['id']);
        }

        if (isset($contactUsMessageData['fullName'])) {
            $contactUsMessageEntity->setFullName($contactUsMessageData['fullName']);
        }        

        if (isset($contactUsMessageData['email'])) {
            $contactUsMessageEntity->setEmail($contactUsMessageData['email']);
        }        

        if (isset($contactUsMessageData['phone'])) {
            $contactUsMessageEntity->setPhone($contactUsMessageData['phone']);
        }

        if (isset($contactUsMessageData['createdAt'])) {
            if (!DateTime::createFromFormat("Y-m-d H:i:s", $contactUsMessageData['createdAt']))
                throw new InvalidArgumentDomainException("Invalid createdAt parameter to create ContactUsMessage entity"); 

            $contactUsMessageEntity->setCreatedAt(
                new DateTimeVO(
                    new DateTime($contactUsMessageData['createdAt'])
                )
            );
        }

        //dd('ggg');
        $userArr = $contactUsMessageData['userArr'] ?? [];
        if(is_array($userArr) && !empty($userArr)){     
            $msgOwner = (new UserFactory())->createObjTree($userArr);
            $contactUsMessageEntity->setCreator($msgOwner);
        }            
        return $contactUsMessageEntity;
    }


    public function createObj(array $contactUsMessageData): ContactUsMessageEntity {          
        if(!isset($contactUsMessageData['message']))        
            throw new MissingArgumentDomainException("Missing message parameter for create ContactUsMessage entity");              
        
        if(!isset($contactUsMessageData['subject']))       
            throw new MissingArgumentDomainException("Missing subject parameter for create ContactUsMessage entity");              
                

        //type validations
        if(!is_string($contactUsMessageData['message']) || ($contactUsMessageData['message'] === ''))      
            throw new InvalidArgumentDomainException("Invalid message parameter to create ContactUsMessage entity");

        if(!is_string($contactUsMessageData['subject']) || ($contactUsMessageData['subject'] === ''))      
            throw new InvalidArgumentDomainException("Invalid subject parameter to create ContactUsMessage entity");

        if(isset($contactUsMessageData['email'])){
            if(!filter_var($contactUsMessageData['email'], FILTER_VALIDATE_EMAIL)) 
                throw new InvalidArgumentDomainException("Invalid email parameter for ContactUsMessage entity");             
        }


        $contactUsMessageEntity = new ContactUsMessageEntity(
            $contactUsMessageData['message'],
            $contactUsMessageData['subject']
        );

        if (!isset($contactUsMessageData['id']) || $contactUsMessageData['id'] == null) {
            $contactUsMessageData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($contactUsMessageData['uuid'])) {
            $contactUsMessageEntity->setUuid($contactUsMessageData['uuid']);
        }

        if (isset($contactUsMessageData['id'])) {
            $contactUsMessageEntity->setId($contactUsMessageData['id']);
        }

        if (isset($contactUsMessageData['fullName'])) {
            $contactUsMessageEntity->setFullName($contactUsMessageData['fullName']);
        }        

        if (isset($contactUsMessageData['email'])) {
            $contactUsMessageEntity->setEmail($contactUsMessageData['email']);
        }        

        if (isset($contactUsMessageData['phone'])) {
            $contactUsMessageEntity->setPhone($contactUsMessageData['phone']);
        } 

        if (isset($contactUsMessageData['createdAt'])) {
            if (!DateTime::createFromFormat("Y-m-d H:i:s", $contactUsMessageData['createdAt']))
                throw new InvalidArgumentDomainException("Invalid createdAt parameter to create AuthorSalary entity"); 

            $contactUsMessageEntity->setCreatedAt(
                new DateTimeVO(
                    new DateTime($contactUsMessageData['createdAt'])
                )
            );
        }  

        return $contactUsMessageEntity;
    }

}
