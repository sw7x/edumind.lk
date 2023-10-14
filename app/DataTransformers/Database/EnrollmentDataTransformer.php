<?php

namespace App\DataTransformers\Database;

use App\Domain\Enrollment as EnrollmentEntity;

use App\DataTransferObjects\EnrollmentDto;
use App\DataTransferObjects\Factories\EnrollmentDtoFactory;
use App\Mappers\EnrollmentMapper;
use App\Domain\Factories\EnrollmentFactory;

use App\Repositories\UserRepository;
use App\Repositories\CourseItemRepository;


class EnrollmentDataTransformer{

	public static function buildDto(array $EnrollmentRecData) : EnrollmentDto {        
        
        $enrollmentEntity 	= self::buildEntity($EnrollmentRecData);
        $enrollmentDto    	= EnrollmentDtoFactory::fromArray($enrollmentEntity->toArray());
		return $enrollmentDto;
	}

	public static function buildEntity(array $EnrollmentRecData) : EnrollmentEntity {
 
		if(!isset($EnrollmentRecData['course_item_arr'])){
        	$courseSelId 							= $EnrollmentRecData['course_selection_id'];
        	$EnrollmentRecData['course_item_arr'] 	= is_null($courseSelId) ? [] : (new CourseItemRepository())->findDataArrById($courseSelId);
        }		

        if(!isset($EnrollmentRecData['student_arr'])){
        	$studentId 							= $EnrollmentRecData['student_id'];
        	$EnrollmentRecData['student_arr'] 	= is_null($studentId) ? [] : (new UserRepository())->findDataArrById($studentId);
        }

        $enrollmentEntityArr = EnrollmentMapper::dbRecConvertToEntityArr($EnrollmentRecData);
        $enrollmentEntity    = (new EnrollmentFactory())->createObjTree($enrollmentEntityArr);
        return $enrollmentEntity;
	}
} 	

/*          
$rr = (new EnrollmentRepository())->findDataArrById(20);
dump($rr);
dump(EnrollmentBuilder::buildDto($rr));
dump('-----------------------');

$user11 = Enrollment::find(20);
dump($user11);
dump($user11->toArray());
dump(EnrollmentBuilder::buildDto($rr));

dd('k');

*/
