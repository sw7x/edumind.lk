<?php

namespace App\Builders;

use App\Domain\ContactUsMessage as ContactUsMessageEntity;
use App\DataTransferObjects\ContactUsMessageDto;
use App\DataTransferObjects\Factories\ContactUsMessageDtoFactory;
use App\Mappers\ContactUsMapper;
use App\Domain\Factories\ContactUsFactory;
use App\Repositories\UserRepository;

class ContactUsMessageBuilder{

	public static function buildDto(array $contactUsMessageRecData) : ContactUsMessageDto {        
        $contactUsMessageEntity = self::buildEntity($contactUsMessageRecData);
        $contactUsMessageDto    = ContactUsMessageDtoFactory::fromArray($contactUsMessageEntity->toArray());
		return $contactUsMessageDto;

	}

	public static function buildEntity(array $contactUsMessageRecData) : ContactUsMessageEntity {
        if(!isset($contactUsMessageRecData['user_arr'])){
        	$userId 						= $contactUsMessageRecData['user_id'];
        	$contactUsMessageRecData['user_arr'] 	= is_null($userId) ? [] : (new UserRepository())->findDataArrById($userId);
        }
        
        $contactUsMessageEntityArr = ContactUsMapper::dbRecConvertToEntityArr($contactUsMessageRecData);
        $contactUsMessageEntity    = (new ContactUsFactory())->createObjTree($contactUsMessageEntityArr);
        return $contactUsMessageEntity;

	}
} 	

