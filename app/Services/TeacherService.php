<?php


namespace App\Services;




use App\Models\User;
use Sentinel;

class TeacherService
{



    public function loadPopularTeachers(){
        //load 8 teachers that have higher number of courses

        $popularTeachers = User::withCount('getTeachingCourses')->orderBy('get_teaching_courses_count', 'desc')->skip(0)->take(8)->get();;
        //$popularTeachers = User::withCount('enrolled_courses')->orderBy('enrolled_courses_count', 'desc')->skip(0)->take(8)->get();;

        //dd($popularTeachers);

        //return null;
        return $popularTeachers;


    }


    public function getPublishedCoursesByTeacher(User $teacher){
        return $teacher->getTeachingCourses()->where('status','published')->get();
    }

    public function getAllCoursesByTeacher(User $teacher){
        //dd($teacher->getTeachingCourses()->get());
        return $teacher->getTeachingCourses()->get();

    }



    public function getAllTeachers(){
        //dd($teacher->getTeachingCourses()->get());
        $teachers   =   Sentinel::findRoleBySlug('teacher')->users()->with('roles')->where('status',1)->orderBy('id')->get();
        return $teachers;
    }

}
