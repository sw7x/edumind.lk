<?php

namespace App\DataTransformers\Database;

use App\Domain\Subject as SubjectEntity;
use App\DataTransferObjects\SubjectDto;
use App\DataTransferObjects\Factories\SubjectDtoFactory;
use App\Mappers\SubjectMapper;
use App\Domain\Factories\SubjectFactory;
use App\Repositories\UserRepository;

class SubjectDataTransformer{

	public static function buildDto(array $subjectRecData) : SubjectDto {        
        $subjectEntity      = self::buildEntity($subjectRecData);
        $subjectDto         = SubjectDtoFactory::fromArray($subjectEntity->toArray());
        return $subjectDto;
    }


    public static function buildEntity(array $subjectRecData) : SubjectEntity {
        if(!isset($subjectRecData['creator_arr'])){
            $authorId                       = $subjectRecData['author_id'];
            $subjectRecData['creator_arr']  = is_null($authorId) ? [] : (new UserRepository())->findDataArrById($authorId);
            $subjectRecData['creator_id']   = $authorId;
        }
        //dd($subjectRecData);  
        $subjectEntityArr   = SubjectMapper::dbRecConvertToEntityArr($subjectRecData);
        $subjectEntity      = (new SubjectFactory())->createObjTree($subjectEntityArr);
        return $subjectEntity;
    }


	public static function entityToDbRecArr(SubjectEntity $subject) : array {
        $subjectEntityArr   = $subject->toArray();
        $payloadArr         = SubjectMapper::entityConvertToDbArr($subjectEntityArr);
        unset($payloadArr['creator_arr']);
        return $payloadArr;
    }


    public static function dtoToDbRecArr(SubjectDto $subjectDto) : array {
        $subjectEntity  = (new SubjectFactory())->createObjTree($subjectDto->toArray());
        $payloadArr     = self::entityToDbRecArr($subjectEntity);
        return $payloadArr;
    }
} 	

