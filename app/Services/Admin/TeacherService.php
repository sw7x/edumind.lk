<?php

namespace App\Services\Admin;

use App\Models\User as UserModel;
use Sentinel;

use App\Models\Course as CourseModel;
use App\Mappers\CourseMapper;

use App\Domain\Factories\CourseFactory;
use App\DataTransferObjects\Factories\CourseDtoFactory;
use App\Repositories\CourseRepository;
use App\Repositories\UserRepository;

use App\Builders\UserBuilder;
use App\Builders\CourseBuilder;


class TeacherService
{

    private UserRepository $userRepository;
    private CourseRepository $courseRepository;

    function __construct(UserRepository $userRepository,CourseRepository $courseRepository ){
        $this->userRepository   = $userRepository;
        $this->courseRepository = $courseRepository;
    }

    public function getAllCoursesByTeacher(UserModel $teacher){
        $teacherCourses = $this->courseRepository->getPublishedCoursesByTeacher($teacher);

        $dataArr = array();
        $teacherCourses->each(function (CourseModel $record, int $key) use (&$dataArr){
            $dataArr[]          = CourseBuilder::buildDto($record->toArray());
            /*$courseArr       = $this->courseRepository->findDataArrById($record->id);
            $courseEntityArr = CourseMapper::dbRecConvertToEntityArr($courseArr);
            $courseEntity    = (new CourseFactory())->createObjTree($courseEntityArr);
            $courseDto       =  CourseDtoFactory::fromArray($courseEntity->toArray());
            $dataArr[]       = $courseDto; */
        });
        return $dataArr;        
    }

    public function loadAllAvailableTeachers(){        
        $teachers = $this->userRepository->findAllAvailableTeachers();
        $dataArr = array();
        $teachers->each(function (UserModel $record, int $key) use (&$dataArr){           
            $dataArr[]       = UserBuilder::buildDto($record->toArray());              
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


