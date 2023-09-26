<?php
namespace App\Services;

use App\Models\Course as CourseModel;

use App\Exceptions\CustomException;

use Sentinel;
use App\Builders\UserBuilder;
use App\Builders\CourseBuilder;

use App\Repositories\CourseRepository;
use App\Repositories\UserRepository;

//use App\DataTransferObjects\UserDto;
//use App\Models\CourseSelection;
//use App\Models\User;

class StudentService
{

    
	public function loadStudentDataByUserName(string $username) : array {
		$user = (new UserRepository())->findUserByUsername($username);
		if(is_null($user))
			throw new CustomException('Access denied');

        $role = optional($user->roles()->first())->name;
        if($role != 'student')
			throw new CustomException('Wrong user type');

		return array(
			'dto' 		=> UserBuilder::buildDto($user->toArray()),
			'createdAt' => $user->created_at
		);
	}


	public function getLoggedInUserEnrolledCourses() : array {
		$user = Sentinel::getUser();
		if(is_null($user))
			throw new CustomException('Access denied');

		$role = optional($user->roles()->first())->name;
		if($role !='student')
			throw new CustomException('Wrong user type');

		$studentCourses = (new CourseRepository())->getEnrolledCoursesByStudent($user);
		//dd($studentCourses);

		$dataArr = array();
        $studentCourses->each(function (CourseModel $record, int $key) use (&$dataArr){
            $tempArr 				= [];
            $tempArr['dto'] 		= CourseBuilder::buildDto($record->toArray());
            $tempArr['isComplete']	= $record->is_complete;
            $dataArr[] 				= $tempArr;
        });
        return $dataArr;
    }








}



// stud view his profile - front side
//  stud edit his profile - front side
