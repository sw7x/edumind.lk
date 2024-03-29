<?php

namespace App\DataTransformers\Database;

use App\Domain\Course as CourseEntity;
use App\DataTransferObjects\CourseDto;
use App\DataTransferObjects\Factories\CourseDtoFactory;
use App\Mappers\CourseMapper;
use App\Domain\Factories\CourseFactory;
use App\Repositories\UserRepository;
use App\Repositories\SubjectRepository;

class CourseDataTransformer{

	public static function buildDto(array $courseRecData) : CourseDto {
        $courseEntity      = self::buildEntity($courseRecData);
		$courseDto    		= CourseDtoFactory::fromArray($courseEntity->toArray());
		return $courseDto;

	}

	public static function buildEntity(array $courseRecData) : CourseEntity {
        if(!isset($courseRecData['creator_arr'])){
        	$authorId 						= $courseRecData['teacher_id'];
        	$courseRecData['creator_arr'] 	= is_null($authorId) ? [] : (new UserRepository())->findDataArrById($authorId);
        	$courseRecData['creator_id'] 	= $authorId;
        }

        if(!isset($courseRecData['subject_arr'])){
        	$subjectId 						= $courseRecData['subject_id'];
        	$courseRecData['subject_arr'] 	= is_null($subjectId) ? [] : (new SubjectRepository())->findDataArrById($subjectId);
        }

        //dd($courseRecData);
        $courseEntityArr 	= CourseMapper::dbRecConvertToEntityArr($courseRecData);
        $courseEntity      	= (new CourseFactory())->createObjTree($courseEntityArr);
        return $courseEntity;
	}


    public static function entityToDbRecArr(CourseEntity $course) : array {
        $courseEntityArr   = $course->toArray();
        $payloadArr         = CourseMapper::entityConvertToDbArr($courseEntityArr);
        return $payloadArr;
    }
    

    public static function dtoToDbRecArr(CourseDto $courseDto) : array {
        $courseEntity   = (new CourseFactory())->createObjTree($courseDto->toArray());
        $payloadArr     = self::entityToDbRecArr($courseEntity);
        return $payloadArr;
    }

}

