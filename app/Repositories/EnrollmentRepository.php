<?php

namespace App\Repositories;


use App\Domain\Exceptions\InvalidArgumentException;

use Illuminate\Support\Collection;

use App\Repositories\BaseRepository;
use App\Repositories\UserRepository;
use App\Repositories\Interfaces\IGetDataRepository;

use App\Models\Enrollment as EnrollmentModel;
use App\Mappers\EnrollmentMapper;

//use Illuminate\Database\Eloquent\Collection as EloquentCollection;
//use Illuminate\Database\Eloquent\Model;
//use App\Repositories\CourseSelectionRepository;
//use App\Models\CourseSelection as CourseSelectionModel;
use App\Models\User as UserModel; 
use App\Models\Course as CourseModel;


class EnrollmentRepository extends BaseRepository implements IGetDataRepository{

	public function __construct(){
        parent::__construct(EnrollmentModel::make());
    }


    /**
    * @param array $columns
    * @return Collection
    */
    public function paidAll(array $columns = ['*']) : Collection{
        $query  =   $this->model
                        ->join('invoices', 'enrollments.invoice_id', '=', 'invoices.id')
                        ->join('course_selections', 'enrollments.course_selection_id', '=', 'course_selections.id')
                        ->join('courses', 'course_selections.course_id', '=', 'courses.id')
                        ->join('users as teacherRec', 'courses.teacher_id', '=', 'teacherRec.id')
                        ->join('users as studentRec', 'course_selections.student_id', '=', 'studentRec.id')
                        ->where('courses.price','!=',0)
                        ->orderBy('invoices.checkout_date', 'desc')
                        ->orderBy('enrollments.updated_at', 'desc');

        //return($query->get($columns));

        $arr = array();
        $query->get($columns)->each(function ($collection, $key) use (&$arr){
            $tempArr = array();
            $tempArr = $collection->toArray();

            $course_item_arr = (new CourseItemRepository())->findDataArrById($tempArr['course_selection_id']);
            $student_id      = $course_item_arr['student_id'];
            $student_arr     = $course_item_arr['student_arr'];

            $tempArr['course_item_arr'] = $course_item_arr;
            $tempArr['student_arr']     = $student_arr;
            $tempArr['student_id']      = $student_id;

            $arr[]   = collect($tempArr);
        });
        return collect($arr);
    }



    // TODO
    /**
    * @param array $columns
    * @return Collection
    */
    public function paidAll0(array $columns = ['*']): Collection{
        $query  =   $this
                    ->model
                    ->with([
                        'courseSelection',

                        'customerStudent',
                        //'courseSelection.student',

                        //'courseSelection.course',
                        'ownCourse' => function($query){
                            $query->where('courses.price','!=',0)
                                //$query->where('courses.price','=',36561.00)
                                ->select('courses.id','courses.price');
                        },

                        'courseAuthor'=> function($query){
                            $query->select(
                                'users.id as id',
                                'users.full_name as name'
                            );
                        },
                        //'invoice',
                        'invoice' => function($query){
                            $query->select(
                                'invoices.id',
                                'invoices.checkout_date'
                            );
                        }
                    ])
                    ->join('invoices', 'enrollments.invoice_id', '=', 'invoices.id')
                    ->orderBy('invoices.checkout_date', 'desc')
                    ->orderBy('enrollments.updated_at', 'desc');

        $results = $query->get([
            'enrollments.*',
            'invoices.checkout_date as checkoutDate',
            'invoices.id as invoiceId'
        ]);

        return $results;

        /*
        foreach ($results as $key => $value){
            
            dump($value->courseAuthor->name ?? '');
            dump($value);
            dump($value->customerStudent);
            dump($value->ownCourse);
            dump($value->courseAuthor);
            dump($value->courseSelection);
            dump($value->invoiceId);
            dump($value->checkoutDate);
            dump($value->invoice);
            dump('__________________________________');
            
        }
        return $query->get($columns);
        */
    }


    /**
    * @param array $columns
    * @return Collection
    */
    public function freeAll(array $columns = ['*']) : Collection{
        $query  =   $this->model
                        ->join('course_selections', 'enrollments.course_selection_id', '=', 'course_selections.id')
                        ->join('courses', 'course_selections.course_id', '=', 'courses.id')
                        ->where('courses.price','=',0)
                        ->orderBy('enrollments.updated_at', 'desc');

        return $query->get($columns);
    }

    public function findDataArrById(int $modelId) : array {
        $enrollmentRec =    $this->findById($modelId);
        if(is_null($enrollmentRec)) return [];

        $enrollmentArr =  $enrollmentRec->toArray();
        
        $courseSelId                     = $enrollmentRec->course_selection_id;
        $enrollmentArr['course_item_id'] = $courseSelId;
        //$invoiceId                     = $enrollmentRec->invoice_id;
        $studentId                       = $enrollmentRec->courseSelection->student_id;

        $courseSelectionDataArr = ($courseSelId) ? (new CourseItemRepository())->findDataArrById($courseSelId) : [];
        //$orderDTO             = ($invoiceId) ? (new OrderRepository())->findDataArrById($invoiceId) : [];
        $studentDataArr         = ($studentId) ? (new UserRepository())->findDataArrById($studentId) : [];

        //unset($enrollmentArr['course_selection_id']);
        unset($enrollmentArr['created_at']);
        unset($enrollmentArr['updated_at']);
        unset($enrollmentArr['deleted_at']);

        //$enrollmentArr['order']         = $orderDTO;
        $enrollmentArr['course_item_arr']   = $courseSelectionDataArr;
        $enrollmentArr['student_arr']       = $studentDataArr;
        $enrollmentArr['student_id']        = $studentId;

        return $enrollmentArr;
    }


    public function findDtoDataById(int $modelId) : array {
        $data = $this->findDataArrById($modelId);
        return EnrollmentMapper::dbRecConvertToEntityArr($data);
    }



    public function findEnrollmentByStudent(array $columns = ['*']) : Collection {

    }

    
    public function getStudentEnrolledRecsByCourseId(UserModel $studentRec, CourseModel $courseRec) : EnrollmentModel {
        $enrolledRecs   =   $this->model->join('course_selections', function($join) use ($studentRec, $courseRec){
                                $join->on('enrollments.course_selection_id','=','course_selections.id')
                                    ->where('course_selections.student_id', '=', $studentRec->id)
                                    ->where('course_selections.course_id', '=', $courseRec->id);
                            })
                            ->join('courses','course_selections.course_id','=','courses.id')
                            ->where(function ($query) {
                                $query->where(function ($query) {
                                    // for paid courses
                                    $query->whereNotNull('course_selections.cart_added_date')
                                        ->where('course_selections.is_checkout', 1)
                                        ->where('courses.price', '!=', 0);

                                })->orWhere(function ($query) {
                                    // for free courses
                                    $query->whereNull('course_selections.cart_added_date')
                                        ->where('course_selections.is_checkout', 0)
                                        ->where('courses.price', '=', 0);
                                });
                            })
                            ->latest('enrollments.id')                            
                            ->first([
                                //'course_selections.*',
                                'enrollments.*',
                                //'courses.*'
                            ]);
                            //->toArray()
                            //->toSql();
        
        //dump($enrolledRecs->toSql());
        //dump($enrolledRecs->getBindings());
        //dd($enrolledRecs->get());
        return $enrolledRecs;
    }
    
    public function findAllPaidEnrollmentsByStudent(UserModel $studentRec, array $columns = ['enrollments.*']) : Collection {
        $enrolledRecs   =   $this->model->join('course_selections', function($join) use ($studentRec){
                                $join->on('enrollments.course_selection_id','=','course_selections.id')
                                    ->where('course_selections.student_id', '=', $studentRec->id);
                            })
                            ->join('courses','course_selections.course_id','=','courses.id')
                            ->where(function ($query) {                                
                                // for paid courses
                                $query->whereNotNull('course_selections.cart_added_date')
                                    ->where('course_selections.is_checkout', 1)
                                    ->where('courses.price', '!=', 0);                                
                            
                            })
                            ->latest('enrollments.id')                            
                            ->get($columns);
                            //->toArray()
                            //->toSql();
        
        //dump($enrolledRecs->toSql());
        //dump($enrolledRecs->getBindings());
        //dd($enrolledRecs->get());
        return $enrolledRecs;
    }

}



