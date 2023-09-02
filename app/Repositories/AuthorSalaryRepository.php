<?php

namespace App\Repositories;


use App\Repositories\BaseRepository;
use App\Repositories\UserRepository;

use App\Models\AuthorSalary as AuthorSalaryModel;
use App\Repositories\Interfaces\IGetDtoDataRepository;
use App\Mappers\AuthorSalaryMapper;

class AuthorSalaryRepository extends BaseRepository implements IGetDtoDataRepository{

    public function __construct(){
        parent::__construct(AuthorSalaryModel::make());
    }

    public function findDataArrById(int $authorSalaryId): array {

        $authorSalaryRec  =   $this->findById($authorSalaryId);
        if(is_null($authorSalaryRec)) return [];

        $authorSalaryArr = $authorSalaryRec->toArray();

        unset($authorSalaryArr['created_at']);
        unset($authorSalaryArr['updated_at']);
        unset($authorSalaryArr['deleted_at']);

        $userRecs   =   $this->model
                            ->join('enrollments', 'author_salaries.id', '=', 'enrollments.salary_id')
                            ->join('course_selections', 'enrollments.course_selection_id', '=', 'course_selections.id')
                            ->join('courses', 'course_selections.course_id', '=', 'courses.id')
                            ->join('users', 'courses.teacher_id', '=', 'users.id')
                            ->where('author_salaries.id', $authorSalaryId)
                            ->get(['author_salaries.*', 'users.id as user_id']);

        $userId = $userRecs->isNotEmpty() ? $userRecs->first()->user_id : null;

        $userDataArr = ($userId) ? (new UserRepository())->findDataArrById($userId) : [];
        $authorSalaryArr['author_arr'] =  $userDataArr;
        $authorSalaryArr['author_id'] =  $userId;

        $courseSelRecs  =   $this->model
                                ->join('enrollments', 'author_salaries.id', '=', 'enrollments.salary_id')
                                ->join('course_selections', 'enrollments.course_selection_id', '=', 'course_selections.id')
                                ->where('author_salaries.id',$authorSalaryId)
                                ->orderBy('author_salaries.paid_date')
                                ->get(['course_selections.*']);

        $courseSelRecArr = $courseSelRecs->isNotEmpty() ? $courseSelRecs->toArray() : [];
        //dd($courseSelRecArr);
        $feeDataArr = array();
        foreach ($courseSelRecArr as $courseSelRec) {
            $authorAmount = $courseSelRec['author_amount'];
            if(!$authorAmount) continue;
            $feeDataArr[]    =   array(
                'id'        => $courseSelRec['id'],
                //'uuid'      => $courseSelRec['uuid'],
                'amount'    => $authorAmount,
            );
        }
        $authorSalaryArr['fees'] = $feeDataArr;
		
		return $authorSalaryArr;
    }
    
    public function findDtoDataById(int $authorSalaryId): array {
        $data = $this->findDataArrById($authorSalaryId);
        return AuthorSalaryMapper::dbRecConvertToEntityArr($data);
    }


}