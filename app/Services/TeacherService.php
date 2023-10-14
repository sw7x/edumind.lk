<?php

namespace App\Services;

use Sentinel;

use App\Models\Course as CourseModel;
use App\Models\User as UserModel;
use App\Exceptions\CustomException;
use App\Repositories\CourseRepository;
use App\Repositories\UserRepository;

use App\Models\Role as RoleModel;
//use App\Mappers\CourseMapper;
//use App\Domain\Factories\CourseFactory;
//use App\DataTransferObjects\Factories\CourseDtoFactory;

use App\DataTransformers\Database\CourseDataTransformer;
use App\DataTransformers\Database\UserDataTransformer;

class TeacherService
{

    private UserRepository $userRepository;
    private CourseRepository $courseRepository;

    function __construct(UserRepository $userRepository, CourseRepository $courseRepository){
        $this->userRepository   = $userRepository;
        $this->courseRepository = $courseRepository;
    }


    public function loadTeacherDataByUserName(string $username) : array {
        $user = $this->userRepository->findUserByUsername($username);
        if(is_null($user))
            throw new CustomException('Access denied');

        $role = optional($user->roles()->first())->name;
        if($role != RoleModel::TEACHER)
            throw new CustomException('Wrong user type');

        return array(
            'dbRec'     => $user,
            'dto'       => UserDataTransformer::buildDto($user->toArray()),
            'createdAt' => $user->created_at
        );
    }

    
    public function loadPublishedCoursesByTeacher(UserModel $teacher){
        $courses = $this->courseRepository->getPublishedCoursesByTeacher($teacher);

        $dataArr = array();
        $courses->each(function (CourseModel $record, int $key) use (&$dataArr){
            $dataArr[]          = CourseDataTransformer::buildDto($record->toArray());
        });
        return $dataArr;
    }


    public function loadAllAvailableTeachers() : array {
        $teachers = $this->userRepository->findAllAvailableTeachers();

        $teachersDtoArr = array();
        $teachers->each(function (UserModel $record, int $key) use (&$teachersDtoArr){
            $tempArr['dto']         =   UserDataTransformer::buildDto($record->toArray());
            $tempArr['courseCount'] =   $record->getCourseCount();
            $teachersDtoArr[]       =   $tempArr;
        });
        return $teachersDtoArr;
    }









    public function loadPopularTeachers() : array {
        $courseCount        = 8;
        $popularTeachers    = $this->userRepository->getPopularTeachers($courseCount);

        $teachersDtoArr = array();
        $popularTeachers->each(function (UserModel $record, int $key) use (&$teachersDtoArr){
            $teachersDtoArr[]  =   UserDataTransformer::buildDto($record->toArray());
        });
        return $teachersDtoArr;
    }


    public function loadAllCoursesByTeacher(UserModel $teacher) : array {
        $teacherCourses = $this->courseRepository->getPublishedCoursesByTeacher($teacher);
        //$teacherCourses = $teacher->getTeachingCourses()->get();

        $dataArr = array();
        $teacherCourses->each(function (CourseModel $record, int $key) use (&$dataArr){
            $dataArr[]          = CourseDataTransformer::buildDto($record->toArray());
            /*$courseArr       = (new CourseRepository())->findDataArrById($record->id);
            $courseEntityArr = CourseMapper::dbRecConvertToEntityArr($courseArr);
            $courseEntity    = (new CourseFactory())->createObjTree($courseEntityArr);
            $courseDto       =  CourseDtoFactory::fromArray($courseEntity->toArray());
            $dataArr[]       = $courseDto; */
        });
        return $dataArr;
    }










}



//service only methods - not in entity
    //viewprofile()  - site frontend
    //edit profile   - (teacher can edit his own profile in admin panel)

    //view teacher courses
    //view earnings by teacher



//service methods - also in entity
    //change user status


