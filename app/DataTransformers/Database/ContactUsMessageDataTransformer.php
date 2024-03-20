<?php

namespace App\DataTransformers\Database;

use App\Domain\ContactUsMessage as ContactUsMessageEntity;
use App\DataTransferObjects\ContactUsMessageDto;
use App\DataTransferObjects\Factories\ContactUsMessageDtoFactory;
use App\Mappers\ContactUsMapper;
use App\Domain\Factories\ContactUsFactory;
use App\Repositories\UserRepository;

class ContactUsMessageDataTransformer{

	public static function buildDto(array $contactUsMsgRecData) : ContactUsMessageDto {        
        $contactUsMessageEntity = self::buildEntity($contactUsMsgRecData);
        $contactUsMessageDto    = ContactUsMessageDtoFactory::fromArray($contactUsMessageEntity->toArray());
		return $contactUsMessageDto;

	}

	public static function buildEntity(array $contactUsMsgRecData) : ContactUsMessageEntity {
        if(!isset($contactUsMsgRecData['user_arr'])){
        	$userId 						 = $contactUsMsgRecData['user_id'];
        	$contactUsMsgRecData['user_arr'] = is_null($userId) ? [] : (new UserRepository())->findDataArrIncludingTrashedById($userId);
        }
        
        $contactUsMessageEntityArr = ContactUsMapper::dbRecConvertToEntityArr($contactUsMsgRecData);
        $contactUsMessageEntity    = (new ContactUsFactory())->createObjTree($contactUsMessageEntityArr);
        return $contactUsMessageEntity;

	}
}