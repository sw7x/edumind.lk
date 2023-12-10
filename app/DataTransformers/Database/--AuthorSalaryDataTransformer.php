<?php

namespace App\Database\DataTransformers;

use App\Domain\AuthorSalary as AuthorSalaryEntity;

use App\DataTransferObjects\AuthorSalaryDto;
use App\DataTransferObjects\Factories\AuthorSalaryDtoFactory;
use App\Mappers\AuthorSalaryMapper;
use App\Domain\Factories\AuthorSalaryFactory;

use App\Repositories\UserRepository;

class AuthorSalaryDataTransformer{

	public static function buildDto(array $authorSalaryRecData) : AuthorSalaryDto {       
        $courseItemEntity 	= self::buildEntity($authorSalaryRecData);
        $courseItemDto    	= AuthorSalaryDtoFactory::fromArray($courseItemEntity->toArray());
		return $courseItemDto;
	}

	public static function buildEntity(array $authorSalaryRecData) : AuthorSalaryEntity {
 
		if(!isset($authorSalaryRecData['student_arr'])){
        	$studentId 							= $authorSalaryRecData['student_id'];
        	$authorSalaryRecData['student_arr'] 	= is_null($studentId) ? [] : (new UserRepository())->findDataArrById($authorId);
        }		

        $courseItemEntityArr = AuthorSalaryMapper::dbRecConvertToEntityArr($authorSalaryRecData);
        $courseItemEntity    = (new AuthorSalaryFactory())->createObjTree($courseItemEntityArr);
        return $courseItemEntity;
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


