<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\CourseSelection as CourseSelectionModel;
use Illuminate\Database\Eloquent\Collection;
//use Illuminate\Database\Eloquent\ModelNotFoundException;

class CourseSelectionRepository extends BaseRepository{

	public function __construct(){
        parent::__construct(CourseSelectionModel::make());
    }


    /**
    * @param array $columns
    * @return Collection
    */
    public function allCartItems(array $columns = ['*']) : Collection {
        $query  =   $this->model
                        ->join('courses', 'course_selections.course_id', '=', 'courses.id')
                        ->where('course_selections.is_checkout', 0)
                        ->where('course_selections.cart_added_date', '!=', null)
                        ->where('courses.price', '!=', 0)
                        ->orderBy('course_selections.cart_added_date','desc');

        /*dd($query->toSql());*/
        return  $query->get($columns);
    }

    /**
    * @param array $columns
    * @param int $modelId
    * @return Collection
    */
    public function cartItemsByStudentId( int $userModelId, array $columns = ['*']) : array {
        $cartRecords    =   $this->model
                                ->join('courses', 'course_selections.course_id', '=', 'courses.id')
                                ->where('course_selections.student_id', $userModelId)
                                ->where('course_selections.is_checkout', 0)
                                ->where('course_selections.cart_added_date', '!=', null)
                                ->where('courses.price', '!=', 0)
                                ->orderBy('course_selections.cart_added_date','desc')
                                ->get('course_selections.*');

        $cartRecordsArr =   $cartRecords->toArray();

        foreach ($cartRecordsArr as $arrKey => $modelArr) {

            $courseId        = $cartRecordsArr[$arrKey]['course_id'];
            $studentId       = $cartRecordsArr[$arrKey]['student_id'];
            $usedCouponCode  = $cartRecordsArr[$arrKey]['used_coupon_code'];

            unset($cartRecordsArr[$arrKey]['course_id']);
            unset($cartRecordsArr[$arrKey]['student_id']);
            unset($cartRecordsArr[$arrKey]['used_coupon_code']);
            unset($cartRecordsArr[$arrKey]['created_at']);
            unset($cartRecordsArr[$arrKey]['updated_at']);
            unset($cartRecordsArr[$arrKey]['deleted_at']);

            $courseDataArr      = ($courseId) ? (new CourseRepository())->findDtoDataById($courseId) : [];
            $cartRecordsArr[$arrKey]['course']      =  $courseDataArr;

            $couponDataArr  = ($usedCouponCode) ? (new CouponRepository())->findDtoDataByCode($usedCouponCode) : [];
            $cartRecordsArr[$arrKey]['used_coupon'] =  $couponDataArr;

            $studentDataArr     = ($studentId) ? (new UserRepository())->findDtoDataById($studentId) : [];
            $cartRecordsArr[$arrKey]['student']     =  $studentDataArr;
        }

        return $cartRecordsArr;
    }

}



