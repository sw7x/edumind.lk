<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\CourseSelection as CourseSelectionModel;
use App\Models\User as UserModel;
use App\Models\Course as CourseModel;


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
    * @param int $userModelId
    * @param array $columns
    * @return array
    */
    public function cartItemsByStudentId(int $userModelId, array $columns = ['course_selections.*']) : array {
        $cartRecords    =   $this->model
                                ->join('courses', 'course_selections.course_id', '=', 'courses.id')
                                ->where('course_selections.student_id', $userModelId)
                                ->where('course_selections.is_checkout', 0)
                                ->where('course_selections.cart_added_date', '!=', null)
                                ->where('courses.price', '!=', 0)
                                ->orderBy('course_selections.cart_added_date','desc')
                                ->get($columns);

        $cartRecordsArr =   $cartRecords->toArray();

        foreach ($cartRecordsArr as $arrKey => $modelArr) {

            $courseId        = $cartRecordsArr[$arrKey]['course_id'];
            //$studentId       = $cartRecordsArr[$arrKey]['student_id'];
            $usedCouponCode  = $cartRecordsArr[$arrKey]['used_coupon_code'];

            //unset($cartRecordsArr[$arrKey]['course_id']);
            //unset($cartRecordsArr[$arrKey]['used_coupon_code']);
            unset($cartRecordsArr[$arrKey]['student_id']);
            unset($cartRecordsArr[$arrKey]['created_at']);
            unset($cartRecordsArr[$arrKey]['updated_at']);
            unset($cartRecordsArr[$arrKey]['deleted_at']);

            $courseDataArr = ($courseId) ? (new CourseRepository())->findDataArrById($courseId) : [];
            $cartRecordsArr[$arrKey]['course_arr'] = $courseDataArr;

            $couponDataArr = ($usedCouponCode) ? (new CouponRepository())->findDataArrByCode($usedCouponCode) : [];
            $cartRecordsArr[$arrKey]['used_coupon_arr'] = $couponDataArr;

            /*
            $studentDataArr = ($studentId) ? (new UserRepository())->findDtoDataById($studentId) : [];
            $cartRecordsArr[$arrKey]['student_arr'] = $studentDataArr;
            */
        }

        return $cartRecordsArr;
    }


    /**
    * @param array $columns
    * @param int $courseModelId
    * @param int $studentModelId
    * @return CourseSelectionModel
    */     
    public function getStudentCartItemByCourseId(
        int $courseModelId, 
        int $studentModelId,
        array $columns = ['course_selections.*']
    ) : ?CourseSelectionModel {
        return  $this->model
                    ->join('courses', 'course_selections.course_id', '=', 'courses.id')
                    ->where('course_selections.course_id', $courseModelId)
                    ->where('course_selections.student_id', $studentModelId)
                    ->where('course_selections.is_checkout', 0)
                    ->where('course_selections.cart_added_date', '!=', null)
                    ->where('courses.price', '!=', 0)
                    ->first($columns);

        return $cartRecArr;
    }                        


    public function cartItemCountByStudent(UserModel $userRec) : int {
        return  $this->model
                    ->join('courses', 'course_selections.course_id', '=', 'courses.id')
                    ->where('course_selections.student_id', $userRec->id)
                    ->where('course_selections.is_checkout', 0)
                    ->where('course_selections.cart_added_date', '!=', null)
                    ->where('courses.price', '!=', 0)
                    ->count();
    }

    // retrive the courses from user's cart that were once paid but have now been made free of charge.
    public function getFreeCoursesFromCart(UserModel $userRec) : Collection {
        return $this->model->join('courses', 'course_selections.course_id', '=', 'courses.id')
                    ->where('course_selections.student_id', $userRec->id)
                    ->where('course_selections.is_checkout', 0)
                    ->where('course_selections.cart_added_date', '!=', null)
                    ->where('courses.price', 0)
                    //->toSql()
                    ->get('course_selections.*');            
    }

    /*
    public function deleteFreeCourseInCart(UserModel $userRec, CourseModel $freeCourse) : bool {
        return  $this->model->where('course_selections.student_id', $userRec->id)
                    ->where('course_selections.is_checkout', 0)
                    ->where('course_selections.cart_added_date', '!=', null)
                    ->where('course_selections.course_id', $freeCourse->id)
                    ->delete();
    }
    */
        

    /**
     * Retrieve the courses from the user's cart that have invalid coupon codes.
     * Examples of invalid coupon codes include when the available count is 
     * exceeded, disabled and etc.....
     */
    public function getInavildCouponUsedCoursesFromCart(UserModel $userRec) : Collection {
        return  $this->model->join('courses', 'course_selections.course_id', '=', 'courses.id')
                    ->where('course_selections.student_id', $userRec->id)
                    ->where('course_selections.is_checkout', 0)
                    ->where('course_selections.cart_added_date', '!=', null)

                    ->latest('course_selections.updated_at')
                    ->where('courses.price', '!=', 0)
                    //->where('courses.status', 'published');

                    ->join('coupons', 'course_selections.used_coupon_code', '=', 'coupons.code')
                    ->where(function ($query){
                        $query
                            ->orWhere('coupons.is_enabled', '!=', 1)
                            ->orWhereColumn('coupons.total_count', '<=', 'coupons.used_count')
                            ->orWhere(function ($subQuery){
                                $subQuery->whereNotNull('coupons.cc_course_id')
                                    ->WhereColumn('course_selections.course_id', '!=', 'coupons.cc_course_id');
                            });
                    })
                    //->toSql();
                    // ->get();
                    ->get([
                        'course_selections.*',
                        'coupons.cc_course_id',
                        'coupons.is_enabled',
                        'coupons.total_count',
                        'coupons.used_count'
                    ]);
    }
    
    
    /**
     * Retrieve the courses from the user's cart that have applied coupons 
     * with non-existent foreign key relationships 
     */
    public function getNonExistCouponUsedCoursesFromCart(UserModel $userRec) : Collection {
        return  $this->model->where('course_selections.student_id', $userRec->id)
                    ->whereNotExists(function ($query) {
                        $query->select('code')
                            ->from('coupons')
                            ->whereColumn('coupons.code', 'course_selections.used_coupon_code');
                    })
                    ->whereNotNull('course_selections.used_coupon_code')
                    //->toSql();
                    ->get();
    }    

    // Retrieve the courses from the user's cart that the valid coupons were applied
    public function getValidCouponUsedCoursesFromCart(UserModel $userRec) : Collection {
        return  $this->model->join('courses', 'course_selections.course_id', '=', 'courses.id')
                    ->where('course_selections.student_id', $userRec->id)
                    ->where('course_selections.is_checkout', 0)
                    ->where('course_selections.cart_added_date', '!=', null)

                    ->latest('course_selections.updated_at')
                    ->where('courses.price', '!=', 0)
                    //->where('courses.status', 'published');

                    ->join('coupons', 'course_selections.used_coupon_code', '=', 'coupons.code')

                    ->where('coupons.is_enabled',1)
                    ->whereColumn('coupons.total_count', '>', 'coupons.used_count')
                    ->where(function ($query){
                        $query->orWhereNull('coupons.cc_course_id')
                            ->orWhereColumn('course_selections.course_id', '=', 'coupons.cc_course_id');
                    })
                    //->toSql();
                    ->get('course_selections.*');
    }

}