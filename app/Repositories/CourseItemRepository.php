<?php

namespace App\Repositories;

use App\Repositories\CourseSelectionRepository;
use App\Repositories\CourseRepository;
use App\Repositories\CouponRepository;
use App\Repositories\UserRepository;


use App\Repositories\Interfaces\IGetDataRepository;
use App\Mappers\CourseItemMapper;


class CourseItemRepository implements IGetDataRepository{
    
    public function findDataArrById(int $modelId, array $columns = ['*']) : array {
        
        $courseSelRec = (new CourseSelectionRepository())->findById($modelId);
        if(is_null($courseSelRec)) return [];
        
        $courseSelArr = $courseSelRec->toArray();

        $couponCode = $courseSelArr['used_coupon_code'];
        $courseId   = $courseSelArr['course_id'];
        $studentId  = $courseSelArr['student_id'];
        
        //unset($courseSelArr['used_coupon_code']);
        //unset($courseSelArr['course_id']);
        //unset($courseSelArr['student_id']);
        unset($courseSelArr['created_at']);
        unset($courseSelArr['updated_at']);
        unset($courseSelArr['deleted_at']);

        $courseDataArr  = ($courseId)   ? (new CourseRepository())->findDataArrById($courseId) : [];
        $couponDataArr  = ($couponCode) ? (new CouponRepository())->findDataArrByCode($couponCode) : [];
        $studentDataArr = ($studentId)  ? (new UserRepository())->findDataArrById($studentId) : [];    

        $courseSelArr['course_arr']      = $courseDataArr; 
        $courseSelArr['used_coupon_arr'] = $couponDataArr; 
        $courseSelArr['student_arr']     = $studentDataArr;        
        return $courseSelArr;
    }

    public function findDtoDataById(int $modelId): array {
        $data = $this->findDataArrById($modelId);
        return CourseItemMapper::dbRecConvertToEntityArr($data);
    }
    

}