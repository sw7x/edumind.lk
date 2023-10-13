<?php
namespace App\Services;

use App\Models\Course as CourseModel;
use App\Models\Role as RoleModel;
use App\Models\User as UserModel;
use App\Exceptions\CustomException;

use Sentinel;
use App\Builders\UserBuilder;
use App\Builders\CourseBuilder;

use App\Repositories\CourseRepository;
use App\Repositories\UserRepository;

//use App\DataTransferObjects\UserDto;


class StudentService
{

    
	public function loadStudentDataByUserName(string $username) : array {
		$user = (new UserRepository())->findUserByUsername($username);
		if(is_null($user))
			throw new CustomException('Access denied');

        $role = optional($user->roles()->first())->name;
        if($role != RoleModel::STUDENT)
			throw new CustomException('Wrong user type');

		return array(
			'dto' 		=> UserBuilder::buildDto($user->toArray()),
			'createdAt' => $user->created_at
		);
	}


	public function getStudentEnrolledCourses(?UserModel $student) : array {
		//$user = Sentinel::getUser();
		if(is_null($student))
            abort(404, 'Student not found');

		$role = optional($student->roles()->first())->name;
		if($role !=RoleModel::STUDENT)
			throw new CustomException('Invalid user type');

		$studentCourses = (new CourseRepository())->getEnrolledCoursesByStudent($student);
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


	public function loadStudentEnrolledCoursesByUsername(string $username) : array {
		$student 	= (new UserRepository())->findAvailableUserByUsername($username);
		if(is_null($student))
            abort(404, 'Student not found');
		             
        return $this->getStudentEnrolledCourses($student);
	}





}



// stud view his profile - front side
//  stud edit his profile - front side
