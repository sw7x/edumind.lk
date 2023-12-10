<?php

namespace App\Database\DataTransformers;

use App\Domain\Commission as CommissionEntity;

use App\DataTransferObjects\CommissionDto;
use App\DataTransferObjects\Factories\CommissionDtoFactory;
use App\Mappers\CommissionMapper;
use App\Domain\Factories\CommissionFactory;

use App\Repositories\UserRepository;

class CourseItemDataTransformer{

    public static function buildDto(array $commissionRecData) : CommissionDto {       
        $courseItemEntity   = self::buildEntity($commissionRecData);
        $courseItemDto      = CommissionDtoFactory::fromArray($courseItemEntity->toArray());
        return $courseItemDto;
    }

    public static function buildEntity(array $commissionRecData) : CommissionEntity {
 
        if(!isset($commissionRecData['student_arr'])){
            $studentId                          = $commissionRecData['student_id'];
            $commissionRecData['student_arr']     = is_null($studentId) ? [] : (new UserRepository())->findDataArrById($authorId);
        }       

        $courseItemEntityArr = CommissionMapper::dbRecConvertToEntityArr($commissionRecData);
        $courseItemEntity    = (new CommissionFactory())->createObjTree($courseItemEntityArr);
        return $courseItemEntity;
    }
} 













/*            
$rr = (new CourseItemRepository())->findDataArrById(15);
dump($rr);
dump(CourseItemBuilder::buildDto($rr));
dump('-----------------------');

$user11 = CourseSelection::find(15);
dump($user11);
dump($user11->toArray());
dump(CourseItemBuilder::buildDto($rr));

dd('k');

*/


