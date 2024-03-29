<?php

namespace App\DataTransformers\Database;

use App\Domain\AbstractCourseItem as AbstractCourseItemEntity;
use App\DataTransferObjects\CourseItemDto;
use App\DataTransferObjects\Factories\CourseItemDtoFactory;
use App\Mappers\CourseItemMapper;
use App\Domain\Factories\CourseItemFactory;
use App\Repositories\UserRepository;
use App\Repositories\CourseRepository;
use App\Repositories\CouponRepository;

class CourseItemDataTransformer{

	public static function buildDto(array $courseSelRecData) : CourseItemDto {       
        $courseItemEntity 	= self::buildEntity($courseSelRecData);
        $courseItemDto    	= CourseItemDtoFactory::fromArray($courseItemEntity->toArray());
		return $courseItemDto;
	}

	public static function buildEntity(array $courseSelRecData) : AbstractCourseItemEntity {
        if(!isset($courseSelRecData['course_arr'])){
        	$courseId 							= $courseSelRecData['course_id'];
        	$courseSelRecData['course_arr'] 	= is_null($courseId) ? [] : (new CourseRepository())->findDataArrById($courseId);
        }		

        if(!isset($courseSelRecData['student_arr'])){
        	$studentId 							= $courseSelRecData['student_id'];
        	$courseSelRecData['student_arr'] 	= is_null($studentId) ? [] : (new UserRepository())->findDataArrById($studentId);
        }		

        if(!isset($courseSelRecData['used_coupon_arr'])){
        	$cc 									= $courseSelRecData['used_coupon_code'];
        	$courseSelRecData['used_coupon_arr'] 	= is_null($cc) ? [] : (new CouponRepository())->findDataArrByCode($cc);
        }
        
        $courseItemEntityArr = CourseItemMapper::dbRecConvertToEntityArr($courseSelRecData);
        $courseItemEntity    = (new CourseItemFactory())->createObjTree($courseItemEntityArr);
        return $courseItemEntity;
	}

    public static function entityToDbRecArr(AbstractCourseItemEntity $courseItemEntity) : array {
        $courseItemEntityArr    = $courseItemEntity->toArray();
        $payloadArr             = CourseItemMapper::entityConvertToDbArr($courseItemEntityArr);
        //unset($payloadArr['creator_arr']);
        return $payloadArr;
    }


    public static function dtoToDbRecArr(CourseItemDto $courseItemDto) : array {
        $courseItemEntity   = (new CourseItemFactory())->createObjTree($courseItemDto->toArray());
        $payloadArr         = self::entityToDbRecArr($courseItemEntity);
        return $payloadArr;
    }

} 	


/*            
$rr = (new CourseItemRepository())->findDataArrById(15);
dump($rr);
dump(CourseItemDataTransformer::buildDto($rr));
dump('-----------------------');

$user11 = CourseSelection::find(15);
dump($user11);
dump($user11->toArray());
dump(CourseItemDataTransformer::buildDto($rr));

dd('k');

*/
