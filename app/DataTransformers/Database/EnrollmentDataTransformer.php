<?php

namespace App\DataTransformers\Database;

use App\Domain\Enrollment as EnrollmentEntity;
use App\DataTransferObjects\EnrollmentDto;
use App\DataTransferObjects\Factories\EnrollmentDtoFactory;
use App\Mappers\EnrollmentMapper;
use App\Domain\Factories\EnrollmentFactory;
use App\Repositories\CourseItemRepository;


class EnrollmentDataTransformer{

	public static function buildDto(array $enrollmentRecData) : EnrollmentDto {        
        
        $enrollmentEntity 	= self::buildEntity($enrollmentRecData);
        $enrollmentDto    	= EnrollmentDtoFactory::fromArray($enrollmentEntity->toArray());
		return $enrollmentDto;
	}

	public static function buildEntity(array $enrollmentRecData) : EnrollmentEntity {
 
		if(!isset($enrollmentRecData['course_item_arr'])){
        	$courseSelId 							= $enrollmentRecData['course_selection_id'];
        	$enrollmentRecData['course_item_arr'] 	= is_null($courseSelId) ? [] : (new CourseItemRepository())->findDataArrById($courseSelId);
        }

        if(!isset($enrollmentRecData['student_arr'])){
        	$courseItemRec                     = (new CourseItemRepository())->findDataArrById($enrollmentRecData['course_selection_id']);
            $enrollmentRecData['student_arr']  = $courseItemRec['student_arr'];
        }        

        $enrollmentEntityArr = EnrollmentMapper::dbRecConvertToEntityArr($enrollmentRecData);
        $enrollmentEntity    = (new EnrollmentFactory())->createObjTree($enrollmentEntityArr);
        return $enrollmentEntity;
	}
} 	
