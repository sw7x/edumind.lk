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


class TeacherService
{

    private UserRepository $userRepository;

    function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }

    public function getAllCoursesByTeacher(UserModel $teacher){
        $teacherCourses = $teacher->getTeachingCourses()->withoutGlobalScope('published')->get();
        
        $dataArr = array();
        $teacherCourses->each(function (CourseModel $record, int $key) use (&$dataArr){
            $courseArr       = (new CourseRepository())->findDataArrById($record->id);
            $courseEntityArr = CourseMapper::dbRecConvertToEntityArr($courseArr);
            $courseEntity    = (new CourseFactory())->createObjTree($courseEntityArr);            
            $courseDto       =  CourseDtoFactory::fromArray($courseEntity->toArray());            
            $dataArr[]       = $courseDto;              
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


